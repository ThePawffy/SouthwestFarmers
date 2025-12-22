<?php

namespace App\Http\Controllers\Api;

use App\Models\Party;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\PurchaseDetails;
use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $business_id = auth()->user()->business_id;
        $duration = request('duration');
        $search = request('search');
        $currentDate = Carbon::now();

        $query = Purchase::with(['user:id,name,role', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id,product_type,vat_id,vat_type,vat_amount,unit_id', 'details.stock:id,batch_no,productStock', 'details.product.vat:id,name,rate', 'details.product.category:id,categoryName', 'details.product.unit:id,unitName', 'purchaseReturns.details', 'vat:id,name,rate', 'paymentTypes:id,name', 'payment_type:id,name'])
            ->when(request('returned-purchase') == "true", function ($query) {
                $query->whereHas('purchaseReturns');
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

        // main data
        $data = $query->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
            'total_dueAmount' => $total_dueAmount,
            'total_paidAmount' => $total_paidAmount,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'party_id' => 'required|exists:parties,id'
        ]);

        DB::beginTransaction();
        try {

            $business_id = auth()->user()->business_id;

            if ($request->dueAmount) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $party->due + $request->dueAmount
                ]);
            }

            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance - $request->paidAmount
            ]);

            $purchase = Purchase::create($request->all() + [
                    'user_id' => auth()->id(),
                    'business_id' => $business_id,
                    'meta' => [
                        'note' => $request->note,
                    ],
                ]);

            $paymentTypes = $request->payment_types;

            // Ensure array format
            if (is_string($paymentTypes)) {
                $paymentTypes = json_decode($paymentTypes, true);
            }
            if (!empty($paymentTypes) && is_array($paymentTypes)) {
                $syncData = [];

                foreach ($paymentTypes as $index => $pt) {
                    if (!empty($pt['payment_type_id'])) {
                        $refNumber = $purchase->id + $index;
                        $syncData[$pt['payment_type_id']] = [
                            'amount'   => $pt['amount'],
                            'ref_code' => 'P-' . $refNumber,
                        ];
                    }
                }
                $purchase->paymentTypes()->sync($syncData);
            }

            $purchaseDetails = [];
            foreach ($request->products as $key => $product_data) {

                $batch_no = $product_data['batch_no'] ?? NULL;
                $existingStock = Stock::where(['batch_no' => $batch_no, 'product_id' => $product_data['product_id']])->first();

                // update or create stock
                $stock = Stock::updateOrCreate(
                    ['batch_no' => $batch_no, 'business_id' => $business_id, 'product_id' => $product_data['product_id']],
                    [
                        'product_id' => $product_data['product_id'],
                        'mfg_date' => $product_data['mfg_date'] ?? NULL,
                        'expire_date' => $product_data['expire_date'] ?? NULL,
                        'profit_percent' => $product_data['profit_percent'] ?? 0,
                        'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                        'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                        'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                        'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
                        'productStock' => ($product_data['quantities'] ?? 0) + ($existingStock->productStock ?? 0),
                    ]
                );

                $purchaseDetails[$key] = [
                    'stock_id' => $stock->id,
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_data['product_id'],
                    'quantities' => $product_data['quantities'] ?? 0,
                    'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                    'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                    'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                    'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
                    'profit_percent' => $product_data['profit_percent'] ?? 0,
                    'expire_date' => $product_data['expire_date'] ?? NULL,
                    'mfg_date' => $product_data['mfg_date'] ?? NULL,
                ];
            }

            PurchaseDetails::insert($purchaseDetails);

            DB::commit();
            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $purchase->load('user:id,name,role', 'party:id,name,email,phone,type', 'details', 'details.stock:id,batch_no', 'details.product:id,productName,category_id,product_type', 'details.product.category:id,categoryName', 'purchaseReturns.details', 'vat:id,name,rate','paymentTypes:id,name', 'payment_type:id,name'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'party_id' => 'required|exists:parties,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
        ]);

        DB::beginTransaction();
        try {

            $has_return = PurchaseReturn::where('purchase_id', $purchase->id)->count();

            if ($has_return > 0) {
                return response()->json([
                    'message' => __("You can not update this purchase because it has already been returned.")
                ], 400);
            }

            // Revert previous stock changes
            foreach ($purchase->details as $detail) {
                Stock::where('id', $detail->stock_id)->decrement('productStock', $detail->quantities);
            }

            // Delete existing purchase details
            $purchase->details()->delete();

            $business_id = auth()->user()->business_id;

            $purchaseDetails = [];
            foreach ($request->products as $key => $product_data) {

                $batch_no = $product_data['batch_no'] ?? NULL;
                $existingStock = Stock::where(['batch_no' => $batch_no, 'product_id' => $product_data['product_id']])->first();

                // update or create stock
                $stock = Stock::updateOrCreate(
                    ['batch_no' => $batch_no, 'business_id' => $business_id, 'product_id' => $product_data['product_id']],
                    [
                        'product_id' => $product_data['product_id'],
                        'mfg_date' => $product_data['mfg_date'] ?? NULL,
                        'expire_date' => $product_data['expire_date'] ?? NULL,
                        'profit_percent' => $product_data['profit_percent'] ?? 0,
                        'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                        'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                        'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                        'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
                        'productStock' => ($product_data['quantities'] ?? 0) + ($existingStock->productStock ?? 0),
                    ]
                );

                $purchaseDetails[$key] = [
                    'stock_id' => $stock->id,
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_data['product_id'],
                    'quantities' => $product_data['quantities'] ?? 0,
                    'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                    'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                    'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                    'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
                    'profit_percent' => $product_data['profit_percent'] ?? 0,
                    'expire_date' => $product_data['expire_date'] ?? NULL,
                    'mfg_date' => $product_data['mfg_date'] ?? NULL,
                ];
            }

            PurchaseDetails::insert($purchaseDetails);

            if ($purchase->dueAmount || $request->dueAmount) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $request->party_id == $purchase->party_id ? (($party->due - $purchase->dueAmount) + $request->dueAmount) : ($party->due + $request->dueAmount)
                ]);

                if ($request->party_id != $purchase->party_id) {
                    $prev_party = Party::findOrFail($purchase->party_id);
                    $prev_party->update([
                        'due' => $prev_party->due - $purchase->dueAmount
                    ]);
                }
            }

            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => ($business->remainingShopBalance + $purchase->paidAmount) - $request->paidAmount
            ]);

            $purchase->update($request->all() + [
                    'user_id' => auth()->id(),
                    'meta' => [
                        'note' => $request->note,
                    ],
                ]);

            $paymentTypes = $request->payment_types;
            if (is_string($paymentTypes)) {
                $paymentTypes = json_decode($paymentTypes, true);
            }
            if (!empty($paymentTypes) && is_array($paymentTypes)) {
                $syncData = [];
                foreach ($paymentTypes as $index => $pt) {
                    if (!empty($pt['payment_type_id'])) {
                        $refNumber = $purchase->id + $index;
                        $syncData[$pt['payment_type_id']] = [
                            'amount'   => $pt['amount'],
                            'ref_code' => 'P-' . $refNumber,
                        ];
                    }
                }
                $purchase->paymentTypes()->sync($syncData);
            }


            DB::commit();
            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $purchase->load('user:id,name,role', 'party:id,name,email,phone,type', 'details', 'details.stock:id,batch_no', 'details.product:id,productName,category_id,product_type', 'details.product.category:id,categoryName', 'purchaseReturns.details', 'vat:id,name,rate', 'paymentTypes:id,name', 'payment_type:id,name'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::with('details')->findOrFail($id);

            $has_return = PurchaseReturn::where('purchase_id', $purchase->id)->count();

            if ($has_return > 0) {
                return response()->json([
                    'message' => __("You can not update this purchase because it has already been returned.")
                ], 400);
            }

            if ($purchase->dueAmount) {
                $party = Party::findOrFail($purchase->party_id);
                $party->update([
                    'due' => $party->due - $purchase->dueAmount
                ]);
            }

            foreach ($purchase->details as $detail) {
                Stock::where('id', $detail->stock_id)->decrement('productStock', $detail->quantities);
            }

            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $purchase->paidAmount
            ]);

            $purchase->delete();

            DB::commit();
            return response()->json([
                'message' => __('Data deleted successfully.'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
