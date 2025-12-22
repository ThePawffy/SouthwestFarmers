<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Stock;
use Carbon\Carbon;
use App\Models\Vat;
use App\Models\Sale;
use App\Models\Brand;
use App\Models\Party;
use App\Models\Product;
use App\Models\Business;
use App\Models\Category;
use App\Models\SaleReturn;
use App\Models\PaymentType;
use App\Models\SaleDetails;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class AcnooSaleController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        $salesWithReturns = SaleReturn::where('business_id', auth()->user()->business_id)
            ->pluck('sale_id')
            ->toArray();

        $query = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest();
        if ($request->has('today') && $request->today) {
            $query->whereDate('created_at', Carbon::today());
        }

        $sales = $query->paginate(20);

        return view('businessAddon::sales.index', compact('sales', 'salesWithReturns'));
    }

    public function create()
    {
        $business_id = auth()->user()->business_id;

        // Clears all cart items
        Cart::destroy();

        $customers = Party::where('type', '!=', 'supplier')
            ->where('business_id', $business_id)
            ->latest()
            ->get();

        $products = Product::with('category:id,categoryName', 'unit:id,unitName', 'stocks')
            ->where('business_id', $business_id)
            ->withSum('stocks as total_stock', 'productStock')
            ->having('total_stock', '>', 0)
            ->latest()
            ->get();

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        $categories = Category::where('business_id', $business_id)->latest()->get();
        $brands = Brand::where('business_id', $business_id)->latest()->get();
        $vats = Vat::where('business_id', $business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', $business_id)->whereStatus(1)->latest()->get();

        // Generate a unique invoice number
        $sale_id = (Sale::max('id') ?? 0) + 1;
        $invoice_no = 'S-' . str_pad($sale_id, 5, '0', STR_PAD_LEFT);

        return view('businessAddon::sales.create', compact('customers', 'products', 'cart_contents', 'invoice_no', 'categories', 'brands', 'vats', 'payment_types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'party_id' => 'nullable|exists:parties,id',
            'vat_id' => 'nullable|exists:vats,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'invoiceNumber' => 'required|string',
            'customer_phone' => 'nullable|string',
            'receive_amount' => 'nullable|numeric',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'shipping_charge' => 'nullable|numeric',
            'saleDate' => 'nullable|date',
        ]);

        $business_id = auth()->user()->business_id;

        // Get only 'sale' type items from cart
        $carts = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }

        DB::beginTransaction();
        try {

            // Calculation: subtotal, vat, discount, shipping, rounding
            $subtotal = $carts->sum(fn($item) => (float) $item->subtotal);
            $vat = Vat::find($request->vat_id);
            $vatAmount = $vat ? ($subtotal * $vat->rate) / 100 : 0;

            $discountAmount = $request->discountAmount ?? 0;
            $subtotalWithVat = $subtotal + $vatAmount;

            if ($request->discount_type === 'percent') {
                $discountAmount = ($subtotalWithVat * $discountAmount) / 100;
            }
            if ($discountAmount > $subtotalWithVat) {
                return response()->json(['message' => __('Discount cannot be more than subtotal with VAT!')], 400);
            }

            $shippingCharge = $request->shipping_charge ?? 0;
            $actualTotalAmount = $subtotalWithVat - $discountAmount + $shippingCharge;
            $roundingTotalAmount = sale_rounding($actualTotalAmount);
            $rounding_amount = $roundingTotalAmount - $actualTotalAmount;
            $rounding_option = sale_rounding();

            // Handle payment types
            $paymentTypes = $request->input('payment_types', []);

            if (!empty($paymentTypes)) {
                // multiple payment types
                $receiveAmount = array_sum(array_map(fn($pt) => floatval($pt['amount'] ?? 0), $paymentTypes));
            } else {
                // single payment
                $paymentTypes = [
                    [
                        'payment_type_id' => $request->input('payment_type_id'),
                        'amount' => floatval($request->input('receive_amount', 0)),
                    ]
                ];
                $receiveAmount = $paymentTypes[0]['amount'];
            }

            $changeAmount = max($receiveAmount - $roundingTotalAmount, 0);
            $dueAmount = max($roundingTotalAmount - $receiveAmount, 0);
            $paidAmount = $receiveAmount - $changeAmount;

            // Update business balance
            $business = Business::findOrFail($business_id);
            $business->update(['remainingShopBalance' => $business->remainingShopBalance + $paidAmount]);

            // Create sale record
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'business_id' => $business_id,
                'type' => $request->type == 'inventory' ? 'inventory' : 'sale',
                'party_id' => $request->party_id,
                'invoiceNumber' => $request->invoiceNumber,
                'saleDate' => $request->saleDate ?? now(),
                'vat_id' => $request->vat_id,
                'vat_amount' => $vatAmount,
                'discountAmount' => $discountAmount,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                'totalAmount' => $roundingTotalAmount,
                'actual_total_amount' => $actualTotalAmount,
                'rounding_amount' => $rounding_amount,
                'rounding_option' => $rounding_option,
                'paidAmount' => min($paidAmount, $roundingTotalAmount),
                'change_amount' => $changeAmount,
                'dueAmount' => $dueAmount,
                'payment_type_id' => $request->payment_type_id,
                'shipping_charge' => $shippingCharge,
                'isPaid' => $dueAmount > 0 ? 0 : 1,
                'meta' => [
                    'customer_phone' => $request->customer_phone,
                    'note' => $request->note,
                ]
            ]);

            // Sync payment types with pivot table
            $syncData = [];
            foreach ($paymentTypes as $index => $pt) {
                if (!empty($pt['payment_type_id'])) {
                    $refNumber = $sale->id + $index; // use sale id + index for unique ref_code
                    $syncData[$pt['payment_type_id']] = [
                        'amount' => floatval($pt['amount'] ?? 0),
                        'ref_code' => 'P-' . $refNumber,
                    ];
                }
            }

            if (!empty($syncData)) {
                $sale->paymentTypes()->sync($syncData);
            }


            $avgDiscount = $discountAmount / max($carts->count(), 1);
            $totalPurchaseAmount = 0;
            $saleDetailsData = [];

            foreach ($carts as $cartItem) {
                $qty = $cartItem->qty;
                $purchase_price = $cartItem->options->purchase_price ?? 0;
                $stock = Stock::where('id', $cartItem->options->stock_id)->first();

                $lossProfit = (($cartItem->price - $stock->productPurchasePrice) * $cartItem->qty) - $avgDiscount;

                if ($stock->productStock < $qty) {
                    $batchText = $stock->batch_no ? " ($stock->batch_no)" : "";
                    return response()->json([
                        'message' => __($cartItem->name . $batchText . ' - stock not available. Available: ' . $stock->productStock)
                    ], 400);
                }

                $stock->decrement('productStock', $qty);

                $saleDetailsData[] = [
                    'sale_id' => $sale->id,
                    'stock_id' => $cartItem->options->stock_id,
                    'product_id' => $cartItem->id,
                    'price' => $cartItem->price,
                    'lossProfit' => $lossProfit,
                    'quantities' => $cartItem->qty,
                    'productPurchasePrice' => $purchase_price,
                    'expire_date' => $cartItem->options->expire_date ?? null,
                ];

                $totalPurchaseAmount += $purchase_price * $qty;
            }

            // Insert all sale details
            SaleDetails::insert($saleDetailsData);

            $sale->update([
                'lossProfit' => $subtotal - $totalPurchaseAmount - $discountAmount,
            ]);

            // Handle party due and messaging
            if ($dueAmount > 0 && $request->party_id) {
                $party = Party::find($request->party_id);
                if ($party) {
                    $party->update(['due' => $party->due + $dueAmount]);

                    if ($party->phone && env('MESSAGE_ENABLED')) {
                        sendMessage($party->phone, saleMessage($sale, $party, $business->companyName));
                    }
                }
            }

            // Clear all items from cart
            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            // Notify user
            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('New sale created.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Sales created successfully.'),
                'redirect' => route('business.sales.index'),
                'secondary_redirect_url' => route('business.sales.invoice', $sale->id),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }
    }

    public function edit(string $id)
    {
        // Clears all cart items
        Cart::destroy();

        $sale = Sale::with('user:id,name', 'party:id,name,email,phone,type,due', 'details', 'details.stock', 'details.product:id,productName,category_id,unit_id,productCode,productSalePrice,productPicture', 'details.product.category:id,categoryName', 'details.product.unit:id,unitName', 'paymentTypes:id,name', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($id);

        $customers = Party::where('type', '!=', 'supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $products = Product::with('category:id,categoryName', 'unit:id,unitName', 'stocks')
            ->where('business_id', auth()->user()->business_id)
            ->withSum('stocks as total_stock', 'productStock')
            ->having('total_stock', '>', 0)
            ->latest()
            ->get();

        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        // Add sale details to the cart
        foreach ($sale->details as $detail) {
            // Add to cart
            Cart::add([
                'id' => $detail->product_id,
                'name' => $detail->product->productName ?? '',
                'qty' => $detail->quantities,
                'price' => $detail->price ?? 0,
                'options' => [
                    'type' => 'sale',
                    'product_code' => $detail->product->productCode ?? '',
                    'product_unit_id' => $detail->product->unit_id ?? null,
                    'product_unit_name' => $detail->product->unit->unitName ?? '',
                    'product_image' => $detail->product->productPicture ?? '',
                    'stock_id' => $detail->stock_id ?? null,
                    'batch_no' => $detail->stock->batch_no ?? '',
                    'expire_date' => $detail->expire_date ?? '',
                    'purchase_price' => $detail->productPurchasePrice ?? 0,
                ],
            ]);
        }

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        if ($sale->type == 'inventory') {
            return view('businessAddon::sales.edit-inventory', compact('sale', 'customers', 'products', 'cart_contents', 'categories', 'brands', 'vats', 'payment_types'));
        } else {
            return view('businessAddon::sales.edit', compact('sale', 'customers', 'products', 'cart_contents', 'categories', 'brands', 'vats', 'payment_types'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'party_id' => 'nullable|exists:parties,id',
            'vat_id' => 'nullable|exists:vats,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'invoiceNumber' => 'required|string',
            'customer_phone' => 'nullable|string',
            'receive_amount' => 'nullable|numeric',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'saleDate' => 'nullable|date',
            'shipping_charge' => 'nullable|numeric',
        ]);

        $business_id = auth()->user()->business_id;
        $carts = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }

        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);
            $prevDetails = $sale->details;

            $totalPurchaseAmount = 0;
            $subtotal = 0;

            foreach ($carts as $cartItem) {
                $prevProduct = $prevDetails->firstWhere('product_id', $cartItem->id);
                $stock = Stock::where('id', $cartItem->options->stock_id ?? null)
                    ->first() ?? Stock::where('product_id', $cartItem->id)->orderBy('id', 'asc')->first();

                if (!$stock) {
                    return response()->json([
                        'message' => __($cartItem->name . ' - no stock found.')
                    ], 400);
                }

                // Adjust available stock by adding back old quantity
                $availableStock = $stock->productStock + ($prevProduct->quantities ?? 0);

                if ($availableStock < $cartItem->qty) {
                    return response()->json([
                        'message' => __($cartItem->name . ' - stock not available for this product. Available quantity is: ' . $availableStock)
                    ], 400);
                }
                $totalPurchaseAmount += $cartItem->options->purchase_price * $cartItem->qty;
                $subtotal += (float)$cartItem->subtotal;
            }

            $vat = Vat::find($request->vat_id);
            $vatAmount = $vat ? ($subtotal * $vat->rate) / 100 : 0;
            $subtotalWithVat = $subtotal + $vatAmount;

            $discountAmount = $request->discountAmount ?? 0;
            if ($request->discount_type == 'percent') {
                $discountAmount = ($subtotalWithVat * $discountAmount) / 100;
            }
            if ($discountAmount > $subtotalWithVat) {
                return response()->json(['message' => __('Discount cannot be more than subtotal with VAT!')], 400);
            }

            $shippingCharge = $request->shipping_charge ?? 0;
            $actualTotalAmount = $subtotalWithVat - $discountAmount + $shippingCharge;
            $roundingTotalAmount = sale_rounding($actualTotalAmount, $sale->rounding_option);
            $rounding_amount = $roundingTotalAmount - $actualTotalAmount;

            // Handle payment types
            $paymentTypes = $request->input('payment_types', []);
            if (!empty($paymentTypes)) {
                $receiveAmount = array_sum(array_map(fn($pt) => floatval($pt['amount'] ?? 0), $paymentTypes));
            } else {
                $paymentTypes = [
                    [
                        'payment_type_id' => $request->input('payment_type_id'),
                        'amount' => floatval($request->input('receive_amount', 0)),
                    ]
                ];
                $receiveAmount = $paymentTypes[0]['amount'];
            }

            $changeAmount = $receiveAmount > $roundingTotalAmount ? $receiveAmount - $roundingTotalAmount : 0;
            $dueAmount = max($roundingTotalAmount - $receiveAmount, 0);
            $paidAmount = $receiveAmount - $changeAmount;

            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $paidAmount - $sale->paidAmount,
            ]);

            $sale->update([
                'invoiceNumber' => $request->invoiceNumber,
                'saleDate' => $request->saleDate ?? now(),
                'vat_id' => $request->vat_id,
                'vat_amount' => $vatAmount,
                'discountAmount' => $discountAmount,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                'totalAmount' => $roundingTotalAmount,
                'actual_total_amount' => $actualTotalAmount,
                'rounding_amount' => $rounding_amount,
                'lossProfit' => $subtotal - $totalPurchaseAmount - $discountAmount,
                'paidAmount' => $paidAmount > $roundingTotalAmount ? $roundingTotalAmount : $paidAmount,
                'change_amount' => $changeAmount,
                'dueAmount' => $dueAmount,
                'payment_type_id' => $request->payment_type_id,
                'isPaid' => $dueAmount > 0 ? 0 : 1,
                'meta' => [
                    'customer_phone' => $request->customer_phone,
                    'note' => $request->note,
                ]
            ]);

            // Sync payment types with pivot table
            $syncData = [];
            foreach ($request->input('payment_types', []) as $index => $pt) {
                $ptId = intval($pt['payment_type_id'] ?? 0);
                $ptAmount = floatval($pt['amount'] ?? 0);
                if ($ptId > 0) {
                    $refNumber = $sale->id + $index;
                    $syncData[$ptId] = [
                        'amount' => $ptAmount,
                        'ref_code' => 'P-' . $refNumber,
                    ];
                }
            }
            $sale->paymentTypes()->sync($syncData);

            SaleDetails::where('sale_id', $sale->id)->delete();

            $avgDiscount = $discountAmount / $carts->count();
            $saleDetailsData = [];

            foreach ($carts as $cartItem) {
                $prevProduct = $prevDetails->firstWhere('product_id', $cartItem->id);
                $oldQty = $prevProduct ? $prevProduct->quantities : 0;
                $newQty = $cartItem->qty;
                $diffQty = $newQty - $oldQty;

                $lossProfit = (($cartItem->price - $cartItem->options->purchase_price) * $newQty) - $avgDiscount;

                $saleDetailsData[] = [
                    'sale_id' => $sale->id,
                    'stock_id' => $cartItem->options->stock_id,
                    'product_id' => $cartItem->id,
                    'price' => $cartItem->price,
                    'lossProfit' => $lossProfit,
                    'quantities' => $newQty,
                    'expire_date' => $cartItem->options->expire_date ?? null,
                    'productPurchasePrice' => $cartItem->options->purchase_price ?? 0,
                ];

                $stock = Stock::where('id', $cartItem->options->stock_id ?? null)
                    ->first() ?? Stock::where('product_id', $cartItem->id)->orderBy('id', 'asc')->first();

                $stock->productStock += $diffQty;
            }

            SaleDetails::insert($saleDetailsData);

            // Party logic
            if (($sale->dueAmount || $request->dueAmount) && $request->party_id != null) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $request->party_id == $sale->party_id ? (($party->due - $sale->dueAmount) + $dueAmount) : ($party->due + $dueAmount)
                ]);

                if ($request->party_id != $sale->party_id) {
                    $prevParty = Party::findOrFail($sale->party_id);
                    $prevParty->update(['due' => $prevParty->due - $sale->dueAmount]);
                }

                if ($party->phone && env('MESSAGE_ENABLED')) {
                    sendMessage($party->phone, saleMessage($sale, $party, $business->companyName));
                }
            }

            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been updated.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Sales updated successfully.'),
                'redirect' => route('business.sales.index'),
                'secondary_redirect_url' => route('business.sales.invoice', $sale->id),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);

            foreach ($sale->details as $detail) {
                $stock = Stock::find($detail->stock_id);

                if (!$stock) {
                    $stock = Stock::where('product_id', $detail->product_id)->orderBy('id', 'asc')->first();
                }

                if ($stock) {
                    $stock->increment('productStock', $detail->quantities);
                }
            }

            if ($sale->party_id) {
                $party = Party::findOrFail($sale->party_id);
                $party->update(['due' => $party->due - $sale->dueAmount]);
            }

            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance - $sale->paidAmount
            ]);

            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been deleted.'), $sale->business_id);

            $sale->delete();

            // Clears all cart items
            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Sale deleted successfully.'),
                'redirect' => route('business.sales.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();

        try {
            $sales = Sale::whereIn('id', $request->ids)->get();
            $business = Business::findOrFail(auth()->user()->business_id);

            foreach ($sales as $sale) {
                // Restore stock
                foreach ($sale->details as $detail) {
                    $stock = Stock::find($detail->stock_id);

                    if (!$stock) {
                        $stock = Stock::where('product_id', $detail->product_id)->orderBy('id', 'asc')->first();
                    }

                    if ($stock) {
                        $stock->increment('productStock', $detail->quantities);
                    }
                }

                // Adjust party due
                if ($sale->party_id) {
                    $party = Party::findOrFail($sale->party_id);
                    $party->update(['due' => $party->due - $sale->dueAmount]);
                }

                // Adjust business balance
                $business->update([
                    'remainingShopBalance' => $business->remainingShopBalance - $sale->paidAmount
                ]);

                sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been deleted.'), $sale->business_id);

                $sale->delete();
            }

            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Selected sales deleted successfully.'),
                'redirect' => route('business.sales.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function acnooFilter(Request $request)
    {
        $salesWithReturns = SaleReturn::where('business_id', auth()->user()->business_id)
            ->pluck('sale_id')
            ->toArray();

        $query = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id);

        if ($request->has('today')) {
            $query->whereDate('created_at', Carbon::today());
        }

        $query->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('paymentType', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('invoiceNumber', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        });

        $sales = $query->latest()->paginate($request->per_page ?? 10);
        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::sales.datas', compact('sales', 'salesWithReturns'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function productFilter(Request $request)
    {
        $total_products_count = Product::where('business_id', auth()->user()->business_id)
            ->whereHas('stocks', function ($q) {
                $q->where('productStock', '>', 0);
            })
            ->count();

        $products = Product::where('business_id', auth()->user()->business_id)
            ->whereHas('stocks', function ($q) {
                $q->where('productStock', '>', 0);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                        ->orWhere('productCode', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->get();

        $total_products = $products->count();

        if ($request->ajax()) {
            return response()->json([
                'total_products' => $total_products,
                'total_products_count' => $total_products_count,
                'product_id' => $total_products == 1 ? $products->first()->id : null,
                'data' => view('businessAddon::sales.product-list', compact('products'))->render(),
            ]);
        }

        return redirect(url()->previous());
    }

    // Category search Filter
    public function categoryFilter(Request $request)
    {
        $search = $request->search;
        $categories = Category::where('business_id', auth()->user()->business_id)
            ->when($search, function ($query) use ($search) {
                $query->where('categoryName', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json([
            'categories' => view('businessAddon::sales.category-list', compact('categories'))->render(),
        ]);
    }

    // Brand search Filter
    public function brandFilter(Request $request)
    {
        $search = $request->search;
        $brands = Brand::where('business_id', auth()->user()->business_id)
            ->when($search, function ($query) use ($search) {
                $query->where('brandName', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json([
            'brands' => view('businessAddon::sales.brand-list', compact('brands'))->render(),
        ]);
    }

    /** Get customer wise product prices */
    public function getProductPrices(Request $request)
    {
        $type = $request->type;

        $products = Product::where('business_id', auth()->user()->business_id)->get();
        $prices = [];

        foreach ($products as $product) {
            if ($type === 'Dealer') {
                $prices[$product->id] = currency_format($product->productDealerPrice, currency: business_currency());
            } elseif ($type === 'Wholesaler') {
                $prices[$product->id] = currency_format($product->productWholeSalePrice, currency: business_currency());
            } else {
                // For Retailer or any other type
                $prices[$product->id] = currency_format($product->productSalePrice, currency: business_currency());
            }
        }
        return response()->json($prices);
    }

    /** Get customer wise stock prices */
    public function getStockPrices(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $customerType = $request->input('type');
        $cartStocks = $request->input('stocks', []); // optional, only cart rows

        // Fetch all stocks for product list prices
        $allStocks = Stock::where('business_id', $businessId)
            ->where('productStock', '>', 0)
            ->get();

        $productPrices = []; // Product-single prices
        foreach ($allStocks as $stock) {
            // Determine price based on customer type
            if ($customerType === 'Dealer') {
                $productPrices[$stock->product_id] = $stock->productDealerPrice;
            } elseif ($customerType === 'Wholesaler') {
                $productPrices[$stock->product_id] = $stock->productWholeSalePrice;
            } else {
                $productPrices[$stock->product_id] = $stock->productSalePrice;
            }
        }

        // Fetch stocks for cart list prices
        $stockPrices = [];
        if (!empty($cartStocks)) {
            $cartStockIds = collect($cartStocks)->pluck('stock_id')->toArray();

            $cartStockQuery = Stock::where('business_id', $businessId)
                ->whereIn('id', $cartStockIds)
                ->where('productStock', '>', 0)
                ->get();

            foreach ($cartStockQuery as $stock) {
                $batchNo = $stock->batch_no ?? 'default';

                if ($customerType === 'Dealer') {
                    $stockPrices[$stock->id][$batchNo] = $stock->productDealerPrice;
                } elseif ($customerType === 'Wholesaler') {
                    $stockPrices[$stock->id][$batchNo] = $stock->productWholeSalePrice;
                } else {
                    $stockPrices[$stock->id][$batchNo] = $stock->productSalePrice;
                }
            }
        }

        // Return both product and cart prices
        return response()->json([
            'products' => $productPrices,
            'stocks'   => $stockPrices,
        ]);
    }

    /** Get cart info */
    public function getCartData()
    {
        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        $data['sub_total'] = 0;

        foreach ($cart_contents as $cart) {
            $data['sub_total'] += $cart->price;
        }
        $data['sub_total'] = currency_format($data['sub_total'], currency: business_currency());

        return response()->json($data);
    }

    public function getInvoice($sale_id)
    {
        $sale = Sale::where('business_id', auth()->user()->business_id)->with('user:id,name,role', 'party:id,name,phone,address', 'business:id,phoneNumber,companyName,vat_name,vat_no,address', 'details:id,price,quantities,product_id,sale_id,stock_id', 'details.stock:id,batch_no', 'details.product:id,productName', 'payment_type:id,name','paymentTypes')->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });

        // Calculate the initial discount for each product during sale returns
        $total_discount = 0;
        $product_discounts = [];

        foreach ($sale_returns as $return) {
            foreach ($return->details as $detail) {
                // Add the return quantities and return amounts for each sale_detail_id
                if (!isset($product_discounts[$detail->sale_detail_id])) {
                    // Initialize the first occurrence
                    $product_discounts[$detail->sale_detail_id] = [
                        'return_qty' => 0,
                        'return_amount' => 0,
                        'price' => $detail->saleDetail->price,
                    ];
                }

                // Accumulate quantities and return amounts for the same sale_detail_id
                $product_discounts[$detail->sale_detail_id]['return_qty'] += $detail->return_qty;
                $product_discounts[$detail->sale_detail_id]['return_amount'] += $detail->return_amount;
            }
        }

        // Calculate the total discount based on accumulated quantities and return amounts
        foreach ($product_discounts as $data) {
            $product_price = $data['price'] * $data['return_qty'];
            $discount = $product_price - $data['return_amount'];

            $total_discount += $discount;
        }

        return view('businessAddon::sales.invoice', compact('sale', 'sale_returns', 'total_discount'));
    }

    public function generatePDF(Request $request, $sale_id)
    {
        $sale = Sale::where('business_id', auth()->user()->business_id)->with('user:id,name,role', 'party:id,name,phone,address', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,price,quantities,product_id,sale_id,stock_id', 'details.stock:id,batch_no', 'details.product:id,productName', 'payment_type:id,name',)->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });

        // Calculate the initial discount for each product during sale returns
        $total_discount = 0;
        $product_discounts = [];

        foreach ($sale_returns as $return) {
            foreach ($return->details as $detail) {
                // Add the return quantities and return amounts for each sale_detail_id
                if (!isset($product_discounts[$detail->sale_detail_id])) {
                    // Initialize the first occurrence
                    $product_discounts[$detail->sale_detail_id] = [
                        'return_qty' => 0,
                        'return_amount' => 0,
                        'price' => $detail->saleDetail->price,
                    ];
                }

                // Accumulate quantities and return amounts for the same sale_detail_id
                $product_discounts[$detail->sale_detail_id]['return_qty'] += $detail->return_qty;
                $product_discounts[$detail->sale_detail_id]['return_amount'] += $detail->return_amount;
            }
        }

        // Calculate the total discount based on accumulated quantities and return amounts
        foreach ($product_discounts as $data) {
            $product_price = $data['price'] * $data['return_qty'];
            $discount = $product_price - $data['return_amount'];

            $total_discount += $discount;
        }

        $pdf = Pdf::loadView('businessAddon::sales.pdf', compact('sale', 'sale_returns', 'total_discount'));
        return $pdf->download('sales-invoice.pdf');
    }

    public function sendMail(Request $request, $sale_id)
    {
        $sale = Sale::where('business_id', auth()->user()->business_id)->with('user:id,name,role', 'party:id,name,phone,address', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,price,quantities,product_id,sale_id,stock_id', 'details.stock:id,batch_no', 'details.product:id,productName', 'payment_type:id,name')->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });

        // Calculate the initial discount for each product during sale returns
        $total_discount = 0;
        $product_discounts = [];

        foreach ($sale_returns as $return) {
            foreach ($return->details as $detail) {
                // Add the return quantities and return amounts for each sale_detail_id
                if (!isset($product_discounts[$detail->sale_detail_id])) {
                    // Initialize the first occurrence
                    $product_discounts[$detail->sale_detail_id] = [
                        'return_qty' => 0,
                        'return_amount' => 0,
                        'price' => $detail->saleDetail->price,
                    ];
                }

                // Accumulate quantities and return amounts for the same sale_detail_id
                $product_discounts[$detail->sale_detail_id]['return_qty'] += $detail->return_qty;
                $product_discounts[$detail->sale_detail_id]['return_amount'] += $detail->return_amount;
            }
        }

        // Calculate the total discount based on accumulated quantities and return amounts
        foreach ($product_discounts as $data) {
            $product_price = $data['price'] * $data['return_qty'];
            $discount = $product_price - $data['return_amount'];

            $total_discount += $discount;
        }

        $pdf = Pdf::loadView('businessAddon::sales.pdf', compact('sale', 'sale_returns', 'total_discount'));

        // Send email with PDF attachment
        Mail::raw('Please find attached your sales invoice.', function ($message) use ($pdf) {
            $message->to(auth()->user()->email)
                ->subject('Sales Invoice')
                ->attachData($pdf->output(), 'sales-invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });

        return response()->json([
            'message' => __('Email Sent Successfully.'),
            'redirect' => route('business.sales.index'),
        ]);
    }

    public function createCustomer(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|max:20|' . Rule::unique('parties')->where('business_id', auth()->user()->business_id),
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Retailer,Dealer,Wholesaler,Supplier',
            'email' => 'nullable|email',
            'image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif,webp,svg',
            'address' => 'nullable|string|max:255',
            'due' => 'nullable|numeric|min:0',
        ]);

        Party::create($request->except('image', 'due') + [
            'due' => $request->due ?? 0,
            'image' => $request->image ? $this->upload($request, 'image') : NULL,
            'business_id' => auth()->user()->business_id
        ]);

        return response()->json([
            'message'   => __('Customer created successfully'),
            'redirect'  => route('business.sales.create')
        ]);
    }

    public function createInventory()
    {
        // Clears all cart items
        Cart::destroy();

        $customers = Party::where('type', '!=', 'supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $products = Product::with([
            'stocks' => function ($query) {
                $query->where('productStock', '>', 0);
            },
            'category:id,categoryName',
            'unit:id,unitName'
        ])
            ->where('business_id', auth()->user()->business_id)
            ->withSum('stocks as total_stock', 'productStock')
            ->having('total_stock', '>', 0)
            ->latest()
            ->get();

        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        // Generate a unique invoice number
        $sale_id = (Sale::max('id') ?? 0) + 1;
        $invoice_no = 'S-' . str_pad($sale_id, 5, '0', STR_PAD_LEFT);

        return view('businessAddon::sales.inventory', compact('customers', 'products', 'invoice_no', 'categories', 'vats', 'payment_types'));
    }

    public function viewPayments($id)
    {
        $sale = Sale::with(['paymentTypes', 'payment_type'])->findOrFail($id);

        if ($sale->paymentTypes->isNotEmpty()) {
            $payments = $sale->paymentTypes->map(function ($paymentType) {
                return [
                    'created_at'   => formatted_date($paymentType->pivot->created_at),
                    'ref_code'     => $paymentType->pivot->ref_code,
                    'amount'       => currency_format($paymentType->pivot->amount),
                    'payment_type' => $paymentType->name,
                ];
            });
        } else {
            $payments = collect([
                [
                    'created_at'   => formatted_date($sale->created_at),
                    'ref_code'     => '-',
                    'amount'       => currency_format($sale->paidAmount),
                    'payment_type' => $sale->payment_type_id
                        ? ($sale->payment_type->name ?? '')
                        : ($sale->paymentType ?? ''),
                ]
            ]);
        }

        return response()->json(['payments' => $payments]);
    }


}
