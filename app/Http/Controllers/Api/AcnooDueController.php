<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Models\Party;
use App\Models\Business;
use App\Models\Purchase;
use App\Models\DueCollect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AcnooDueController extends Controller
{


    public function index()
    {
        $business_id = auth()->user()->business_id;
        $duration = request('duration');
        $search = request('search');
        $currentDate = Carbon::now();

        $query = DueCollect::with('user:id,name', 'party:id,name,email,phone,type,due')
            ->where('business_id', $business_id)

            // search filter
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('invoiceNumber', 'like', "%{$search}%")
                        ->orWhereHas('party', function($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
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

        // overall totals
        $total_supplierPayDue = (clone $query)
            ->whereHas('party', fn($q) => $q->where('type', 'Supplier'))
            ->sum('payDueAmount');

        $total_customerPayDue = (clone $query)
            ->whereHas('party', fn($q) => $q->whereIn('type', ['Retailer', 'Dealer', 'Wholesaler']))
            ->sum('payDueAmount');

        // main data
        $data = $query->latest()->get()->map(function($item) {
            if ($item->party) {
                $item->party->paid = $item->payDueAmount ?? 0; // add paid field in party object
            }
            return $item;
        });

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
            'total_supplierPayDue' => $total_supplierPayDue,
            'total_customerPayDue' => $total_customerPayDue,
        ]);
    }

    public function store(Request $request)
    {
        $party = Party::find($request->party_id);

        $request->validate([
            'payment_type_id' => 'required|exists:payment_types,id',
            'party_id' => 'required|exists:parties,id',
            'paymentDate' => 'required|string',
            'payDueAmount' => 'required|numeric',
            'invoiceNumber' => 'nullable|exists:' . ($party->type == 'Supplier' ? 'purchases' : 'sales') . ',invoiceNumber',
        ]);

        if ($request->invoiceNumber) {
            if ($party->type == 'Supplier') {
                $invoice = Purchase::where('invoiceNumber', $request->invoiceNumber)->where('party_id', $request->party_id)->first();
            } else {
                $invoice = Sale::where('invoiceNumber', $request->invoiceNumber)->where('party_id', $request->party_id)->first();
            }

            if (!isset($invoice)) {
                return response()->json([
                    'message' => 'Invoice Not Found.'
                ], 404);
            }

            if ($invoice->dueAmount < $request->payDueAmount) {
                return response()->json([
                    'message' => 'Invoice due is ' . $invoice->dueAmount . '. You can not pay more then the invoice due amount.'
                ], 400);
            }
        }

        if (!$request->invoiceNumber) {
            if ($party->type == 'Supplier') {
                $all_invoice_due = Purchase::where('party_id', $request->party_id)->sum('dueAmount');
            } else {
                $all_invoice_due = Sale::where('party_id', $request->party_id)->sum('dueAmount');
            }

            if (($all_invoice_due + $request->payDueAmount) > $party->due) {
                return response()->json([
                    'message' => __('You can pay only '. $party->due - $all_invoice_due .', without selecting an invoice.')
                ], 400);
            }
        }

        $data = DueCollect::create($request->all() + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                    'sale_id' => $party->type != 'Supplier' && isset($invoice) ? $invoice->id : NULL,
                    'purchase_id' => $party->type == 'Supplier' && isset($invoice) ? $invoice->id : NULL,
                    'totalDue' => isset($invoice) ? $invoice->dueAmount : $party->due,
                    'dueAmountAfterPay' => isset($invoice) ? ($invoice->dueAmount - $request->payDueAmount) : ($party->due - $request->payDueAmount),
                ]);

        if (isset($invoice)) {
            $invoice->update([
                'dueAmount' => $invoice->dueAmount - $request->payDueAmount
            ]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business_name = $business->companyName;
        $business->update([
            'remainingShopBalance' => $party->type == 'Supplier' ? ($business->remainingShopBalance - $request->payDueAmount) : ($business->remainingShopBalance + $request->payDueAmount)
        ]);

        $party->update([
            'due' => $party->due - $request->payDueAmount
        ]);

        if (env('MESSAGE_ENABLED')) {
            sendMessage($party->phone, dueCollectMessage($data, $party, $business_name, $request->invoiceNumber));
        }

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data->load('user:id,name', 'party:id,name,email,phone,type'),
        ]);
    }

    public function invoiceWiseDue()
    {
        $data = Sale::select('id','dueAmount', 'paidAmount', 'totalAmount', 'invoiceNumber', 'saleDate', 'meta')
            ->where('business_id', auth()->user()->business_id)
            ->whereNull('party_id')
            ->where('dueAmount', '>', 0)
            ->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    public function collectInvoiceDue(Request $request)
    {
        $business_id = auth()->user()->business_id;

        $request->validate([
            'payment_type_id' => 'required|exists:payment_types,id',
            'paymentDate' => 'required|string',
            'payDueAmount' => 'required|numeric',
            'invoiceNumber' => 'required|string|exists:sales,invoiceNumber',
        ]);


        DB::beginTransaction();
        try {
            $invoice = Sale::where('business_id', $business_id)->where('invoiceNumber', $request->invoiceNumber)->whereNull('party_id')->first();

            if (!$invoice) {
                return response()->json([
                    'message' => 'Invoice Not Found.'
                ], 404);
            }

            if ($invoice->dueAmount < $request->payDueAmount) {
                return response()->json([
                    'message' => 'Invoice due is ' . $invoice->dueAmount . '. You cannot pay more than the invoice due amount.'
                ], 400);
            }

            $data = DueCollect::create([
                'user_id' => auth()->id(),
                'business_id' => $business_id,
                'sale_id' => $invoice->id,
                'invoiceNumber' => $request->invoiceNumber,
                'totalDue' => $invoice->dueAmount,
                'dueAmountAfterPay' => $invoice->dueAmount - $request->payDueAmount,
                'payDueAmount' => $request->payDueAmount,
                'payment_type_id' => $request->payment_type_id,
                'paymentDate' => $request->paymentDate,
            ]);

            $invoice->update([
                'dueAmount' => $invoice->dueAmount - $request->payDueAmount
            ]);

            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $request->payDueAmount
            ]);

            sendNotifyToUser($data->id, route('business.dues.index', ['id' => $data->id]), __('Due Collection has been created.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Data fetched successfully.'),
                'data' => $data->load('user:id,name', 'party:id,name,email,phone,type'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

}
