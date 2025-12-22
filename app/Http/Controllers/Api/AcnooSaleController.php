<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HasUploader;
use App\Models\Sale;
use App\Models\Party;
use App\Models\Business;
use App\Models\SaleDetails;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcnooSaleController extends Controller
{
    use HasUploader;
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $business_id = auth()->user()->business_id;
        $duration = request('duration');
        $search = request('search');
        $currentDate = Carbon::now();

        $query = Sale::with('user:id,name,role', 'party:id,name,email,phone,type', 'details', 'details.stock:id,batch_no,productStock', 'details.product:id,productName,category_id,product_type', 'details.product.category:id,categoryName', 'saleReturns.details', 'vat:id,name,rate', 'paymentTypes:id,name', 'payment_type:id,name')
            ->when(request('returned-sales') == "true", function ($query) {
                $query->whereHas('saleReturns');
            })
            ->where('business_id', $business_id)

            // search filter
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->whereHas('party', function($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                        ->orWhere('invoiceNumber', 'like', "%{$search}%");
                });
            })

            // duration filter
            ->when($duration, function ($query) use ($duration, $currentDate) {
                switch ($duration) {
                    case 'today':
                        $query->whereDate('created_at', $currentDate);
                        break;

                    case 'yesterday':
                        $query->whereDate('created_at', $currentDate->copy()->subDay());
                        break;

                    case 'last_seven_days':
                        $query->whereBetween('created_at', [
                            $currentDate->copy()->subDays(6)->startOfDay(),
                            $currentDate->endOfDay()
                        ]);
                        break;

                    case 'last_thirty_days':
                        $query->whereBetween('created_at', [
                            $currentDate->copy()->subDays(29)->startOfDay(),
                            $currentDate->endOfDay()
                        ]);
                        break;

                    case 'current_month':
                        $query->whereMonth('created_at', $currentDate->month)
                            ->whereYear('created_at', $currentDate->year);
                        break;

                    case 'last_month':
                        $query->whereMonth('created_at', $currentDate->copy()->subMonth()->month)
                            ->whereYear('created_at', $currentDate->copy()->subMonth()->year);
                        break;

                    case 'current_year':
                        $query->whereYear('created_at', $currentDate->year);
                        break;

                    case 'custom_date':
                        $fromDate = request('from_date');
                        $toDate = request('to_date');
                        if ($fromDate && $toDate) {
                            $query->whereBetween('created_at', [
                                Carbon::parse($fromDate)->startOfDay(),
                                Carbon::parse($toDate)->endOfDay()
                            ]);
                        }
                        break;
                }
            });

        // totals
        $total_dueAmount = (clone $query)->sum('dueAmount');
        $total_paidAmount = (clone $query)->sum('paidAmount');
        $total_profit = (clone $query)->where('lossProfit', '>', 0)->sum('lossProfit');
        $total_loss = abs((clone $query)->where('lossProfit', '<', 0)->sum('lossProfit'));

        // total return amount
        $total_return_amount = (clone $query)
            ->whereHas('saleReturns')
            ->with('saleReturns.details')
            ->get()
            ->flatMap(fn($sale) => $sale->saleReturns->flatMap(fn($return) => $return->details))
            ->sum('return_amount');

        // main data
        $data = $query->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'total_dueAmount' => $total_dueAmount,
            'total_paidAmount' => $total_paidAmount,
            'total_profit' => $total_profit,
            'total_loss' => $total_loss,
            'total_return_amount' => $total_return_amount,
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'party_id' => 'nullable|exists:parties,id',
            'vat_id' => 'nullable|exists:vats,id',
            'products' => 'required',
            'saleDate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'rounding_option' => 'nullable|in:none,round_up,nearest_whole_number,nearest_0.05,nearest_0.1,nearest_0.5',
        ]);

        DB::beginTransaction();
        try {

            $business_id = auth()->user()->business_id;
            $request_products = json_decode($request->products, true);

            $business = Business::findOrFail($business_id);
            $business_name = $business->companyName;
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $request->paidAmount
            ]);

            $lossProfit = collect($request_products)->pluck('lossProfit')->toArray();

            $sale = Sale::create($request->except('image','isPaid') + [
                    'user_id' => auth()->id(),
                    'business_id' => $business_id,
                    'isPaid' => filter_var($request->isPaid, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                    'lossProfit' => array_sum($lossProfit) - $request->discountAmount,
                    'image' => $request->image ? $this->upload($request, 'image') : null,
                    'meta' => [
                        'note' => $request->note,
                        'customer_phone' => $request->customer_phone,
                    ],
                ]);

            $paymentTypes = json_decode($request->payment_types, true);

            if (!empty($paymentTypes)) {
                $syncData = [];

                foreach ($paymentTypes as $index => $pt) {
                    if (!empty($pt['payment_type_id'])) {
                        $refNumber = $sale->id + $index;
                        $syncData[$pt['payment_type_id']] = [
                            'amount' => $pt['amount'],
                            'ref_code' => 'P-' . $refNumber,
                        ];
                    }
                }

                $sale->paymentTypes()->attach($syncData);
            }


            $saleDetails = [];
            foreach ($request_products as $key => $productData) {

                $stock = Stock::findOrFail($productData['stock_id']);

                $saleDetails[$key] = [
                    'sale_id' => $sale->id,
                    'stock_id' => $stock->id,
                    'price' => $productData['price'],
                    'product_id' => $stock->product_id,
                    'lossProfit' => $productData['lossProfit'],
                    'quantities' => $productData['quantities'] ?? 0,
                ];

                $product_name = $productData['product_name'] ?? NULL;

                if ($stock->productStock < $request_products[$key]['quantities']) {
                    return response()->json([
                        'message' => "Stock not availabe for product : " . $product_name . ". Available stock is : " . $stock->productStock
                    ], 406);
                }

                $stock->decrement('productStock', $productData['quantities']);
            }

            SaleDetails::insert($saleDetails);

            if ($party ?? false && $party->phone) {
                if (env('MESSAGE_ENABLED')) {
                    sendMessage($party->phone, saleMessage($sale, $party, $business_name));
                }
            }

            if ($request->dueAmount > 0 && $request->party_id) {
                $party = Party::findOrFail($request->party_id);
                if ($party) {
                    $party->update(['due' => $party->due + $request->dueAmount]);
                    if ($party->phone && env('MESSAGE_ENABLED')) {
                        sendMessage($party->phone, saleMessage($sale, $party, $business_name));
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $sale->load('user:id,name,role', 'party:id,name,email,phone,type', 'details', 'details.stock:id,batch_no', 'details.product:id,productName,category_id,product_type', 'details.product.category:id,categoryName', 'saleReturns.details', 'vat:id,name,rate', 'paymentTypes:id,name', 'payment_type:id,name'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'vat_id' => 'nullable|exists:vats,id',
            'party_id' => 'nullable|exists:parties,id',
            'products' => 'required',
            'saleDate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'rounding_option' => 'nullable|in:none,round_up,nearest_whole_number,nearest_0.05,nearest_0.1,nearest_0.5',
        ]);

        DB::beginTransaction();
        try {

            if ($sale->load('saleReturns')->saleReturns->count() > 0) {
                return response()->json([
                    'message' => __("You can not update this sale because it has already been returned.")
                ], 400);
            }

            $request_products = json_decode($request->products, true);
            $prevDetails = SaleDetails::where('sale_id', $sale->id)->get();
            $stockIds = collect($request_products)->pluck('stock_id')->toArray();
            $current_stocks = Stock::whereIn('id', $stockIds)->get();

            foreach ($current_stocks as $key => $current_stock) {
                $prevStock = $prevDetails->first(function ($item) use ($current_stock) {
                    return $item->stock_id == $current_stock->id;
                });

                $product_name = collect($request_products)->firstWhere('stock_id', $current_stock->id)['product_name'] ?? NULL;

                $product_stock = $prevStock ? ($current_stock->productStock + $prevStock->quantities) : $current_stock->productStock;
                if ($product_stock < $request_products[$key]['quantities']) {
                    return response()->json([
                        'message' => "Stock not available for product : " . $product_name . ". Available stock is : " . $current_stock->productStock
                    ], 406);
                }
            }

            foreach ($prevDetails as $prevItem) {
                Stock::findOrFail($prevItem->stock_id)->decrement('productStock', $prevItem->quantities);
            }

            $prevDetails->each->delete();

            $saleDetails = [];
            foreach ($request_products as $key => $productData) {

                $stock = Stock::findOrFail($productData['stock_id']);

                $saleDetails[$key] = [
                    'sale_id' => $sale->id,
                    'stock_id' => $stock->id,
                    'price' => $productData['price'],
                    'product_id' => $stock->product_id,
                    'lossProfit' => $productData['lossProfit'],
                    'quantities' => $productData['quantities'] ?? 0,
                ];

                $stock->decrement('productStock', $productData['quantities']);
            }

            SaleDetails::insert($saleDetails);

            if ($sale->dueAmount || $request->dueAmount && $request->party_id != null) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $request->party_id == $sale->party_id ? (($party->due - $sale->dueAmount) + $request->dueAmount) : ($party->due + $request->dueAmount)
                ]);

                if ($request->party_id != $sale->party_id) {
                    $prev_party = Party::findOrFail($sale->party_id);
                    $prev_party->update([
                        'due' => $prev_party->due - $sale->dueAmount
                    ]);
                }
            }

            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'remainingShopBalance' => ($business->remainingShopBalance - $sale->paidAmount) + $request->paidAmount
            ]);

            // Party logic
            if (($sale->dueAmount || $request->dueAmount) && $request->party_id != null) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $request->party_id == $sale->party_id ? (($party->due - $sale->dueAmount) + $request->dueAmount) : ($party->due + $request->dueAmount)
                ]);

                if ($request->party_id != $sale->party_id) {
                    $prevParty = Party::findOrFail($sale->party_id);
                    $prevParty->update(['due' => $prevParty->due - $sale->dueAmount]);
                }
            }

            $lossProfit = collect($request_products)->pluck('lossProfit')->toArray();

            $sale->update($request->except('image', 'isPaid') + [
                    'user_id' => auth()->id(),
                    'lossProfit' => array_sum($lossProfit) - $request->discountAmount,
                    'isPaid' => filter_var($request->isPaid, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                    'image' => $request->image ? $this->upload($request, 'image', $sale->image) : $sale->image,
                    'meta' => [
                        'note' => $request->note,
                        'customer_phone' => $request->customer_phone
                    ],
                ]);

            $paymentTypes = json_decode($request->payment_types, true);

            if (!empty($paymentTypes)) {
                $syncData = [];

                foreach ($paymentTypes as $index => $pt) {
                    if (!empty($pt['payment_type_id'])) {
                        $refNumber = $sale->id + $index;
                        $syncData[$pt['payment_type_id']] = [
                            'amount' => $pt['amount'],
                            'ref_code' => 'P-' . $refNumber,
                        ];
                    }
                }

                $sale->paymentTypes()->sync($syncData);
            }

            DB::commit();
            return response()->json([
                'message' => __('Data saved successfully.'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        foreach ($sale->details as $item) {
            Stock::findOrFail($item->stock_id)->increment('productStock', $item->quantities);
        }

        if ($sale->party_id) {
            $party = Party::findOrFail($sale->party_id);
            $party->update(['due' => $party->due - $sale->dueAmount]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update([
            'remainingShopBalance' => $business->remainingShopBalance - $sale->paidAmount
        ]);

        if (file_exists($sale->image)) {
            Storage::delete($sale->image);
        }

        $sale->delete();

        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
