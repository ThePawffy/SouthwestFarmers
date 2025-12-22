<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Sale;
use App\Models\Party;
use App\Models\Business;
use App\Models\Purchase;
use App\Models\DueCollect;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AcnooDueController extends Controller
{
    public function index()
    {
        $total_supplier_due = Party::where('business_id', auth()->user()->business_id)
            ->where('type', 'Supplier')
            ->sum('due');

        $total_customer_due = Party::where('business_id', auth()->user()->business_id)
            ->where('type', '!=', 'Supplier')
            ->sum('due');

        $dues = Party::where('business_id', auth()->user()->business_id)
            ->where('due', '>', 0)
            ->latest()->paginate(20);

        return view('businessAddon::dues.index', compact('dues', 'total_supplier_due', 'total_customer_due'));
    }

    public function acnooFilter(Request $request)
    {
        $dues = Party::where('business_id', auth()->user()->business_id)
            ->where('due', '>', 0)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('type', 'like', '%' . $request->search . '%')
                        ->orwhere('name', 'like', '%' . $request->search . '%')
                        ->orwhere('phone', 'like', '%' . $request->search . '%')
                        ->orwhere('due', 'like', '%' . $request->search . '%')
                        ->orwhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::dues.datas', compact('dues'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function walk_dues()
    {
        $walk_in_customers = Sale::where('business_id', auth()->user()->business_id)->with('dueCollect')->whereNull('party_id')->where('dueAmount', '>', 0)->latest()->paginate(10);
        return view('businessAddon::walk-dues.index', compact('walk_in_customers'));
    }

    public function walk_dues_filter(Request $request)
    {
        $walk_in_customers = Sale::where('business_id', auth()->user()->business_id)
            ->with('dueCollect')
            ->where('dueAmount', '>', 0)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('invoiceNumber', 'like', '%' . $request->search . '%')
                        ->orwhere('dueAmount', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::walk-dues.datas', compact('walk_in_customers'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function collectDue(string $id)
    {
        $party = Party::where('business_id', auth()->user()->business_id)->with(['sales_dues', 'purchases_dues'])->findOrFail($id);
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        $due_amount = 0;

        if ($party->type == 'Supplier') {
            foreach ($party->purchases_dues as $sales_due) {
                $due_amount += $sales_due->dueAmount;
            }
        } else {
            foreach ($party->sales_dues as $sales_due) {
                $due_amount += $sales_due->dueAmount;
            }
        }

        $party_opening_due = $party->due - $due_amount;

        return view('businessAddon::dues.collect-due', compact('party', 'party_opening_due', 'payment_types'));
    }

    public function collectDueStore(Request $request)
    {
        $party = Party::find($request->party_id);

        $request->validate([
            'payment_type_id' => 'required|exists:payment_types,id',
            'paymentDate' => 'required|string',
            'payDueAmount' => 'required|numeric',
            'party_id' => 'required|exists:parties,id',
            'invoiceNumber' => 'nullable|exists:' . ($party->type == 'Supplier' ? 'purchases' : 'sales') . ',invoiceNumber',
        ]);

        $business_id = auth()->user()->business_id;

        DB::beginTransaction();
        try {
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
                        'message' => __('You can pay only ' . $party->due - $all_invoice_due . ', without selecting an invoice.')
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
            $business->update([
                'remainingShopBalance' => $party->type == 'Supplier' ? ($business->remainingShopBalance - $request->payDueAmount) : ($business->remainingShopBalance + $request->payDueAmount)
            ]);

            $party->update([
                'due' => $party->due - $request->payDueAmount
            ]);

            sendNotifyToUser($data->id, route('business.dues.index', ['id' => $data->id]), __('Due Collection has been created.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Collect Due saved successfully'),
                'redirect' => route('business.dues.index'),
                'secondary_redirect_url' => route('business.collect.dues.invoice', $party->id),

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong!'], 404);
        }
    }

    public function getInvoice(string $id)
    {
        $due_collect = DueCollect::with('user:id,name,role', 'party:id,name,email,phone,type,address', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->where('party_id', $id)
            ->latest()
            ->first();

        $party = Party::with('dueCollect.business')->find($id);

        return view('businessAddon::dues.invoice', compact('due_collect', 'party'));
    }

    public function generatePDF(Request $request, string $id)
    {

        $party = Party::with('dueCollect.business')->find($id);

        $due_collects = DueCollect::with('user:id,name', 'party:id,name,email,phone,type', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->where('party_id', $id)
            ->latest()
            ->get();

        $pdf = Pdf::loadview('businessAddon::dues.pdf', compact('due_collects', 'party'));
        return $pdf->download('dues.pdf');
    }

    public function sendMail(Request $request, string $id)
    {
        $party = Party::with('dueCollect.business')->find($id);

        $due_collects = DueCollect::with('user:id,name', 'party:id,name,email,phone,type', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->where('party_id', $id)
            ->latest()
            ->get();
        $pdf = Pdf::loadview('businessAddon::dues.pdf', compact('due_collects', 'party'));


        // Send email with PDF attachment
        Mail::raw('Please find attached your Due Collext invoice.', function ($message) use ($pdf) {
            $message->to(auth()->user()->email)
                ->subject('Sales Invoice')
                ->attachData($pdf->output(), 'collect-due.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });

        return response()->json([
            'message' => __('Email Sent Successfully.'),
            'redirect' => route('business.dues.index'),
        ]);
    }

    public function walkDuesGetInvoice(string $id)
    {
        $due_collect = DueCollect::with('business:id,companyName,vat_name,vat_no','user:id,name,role', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->whereNull('party_id')
            ->latest()
            ->first();

        $walk_in_customer = Sale::with('dueCollect.business')->find($id);

        return view('businessAddon::walk-dues.invoice', compact('due_collect', 'walk_in_customer'));
    }

    public function collectWalkDue(string $id)
    {
        $business_id = auth()->user()->business_id;
        $payment_types = PaymentType::where('business_id', $business_id)->whereStatus(1)->latest()->get();

        $walk_due = Sale::with('dueCollect')->where('business_id', $business_id)->whereNull('party_id')->where('dueAmount', '>', 0)->findOrFail($id);
        $is_walk_in = true;

        return view('businessAddon::walk-dues.collect-due', compact('walk_due', 'payment_types', 'is_walk_in'));
    }

    public function collectWalkDueStore(Request $request)
    {
        $business_id = auth()->user()->business_id;

        $request->validate([
            'payment_type_id' => 'required|exists:payment_types,id',
            'paymentDate' => 'required|string',
            'payDueAmount' => 'required|numeric',
            'invoiceNumber' => 'required|string|exists:sales,invoiceNumber', // Only for walk-in customers (Sales invoices)
        ]);

        DB::beginTransaction();
        try {
            $invoice = Sale::where('invoiceNumber', $request->invoiceNumber)->whereNull('party_id')->first();

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
                'message' => __('Collect Due saved successfully'),
                'redirect' => route('business.walk-dues.index'),
                'secondary_redirect_url' => route('business.collect.walk-dues.invoice', $invoice->id),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong!'], 404);
        }
    }
}
