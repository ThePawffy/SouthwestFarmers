<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\BusinessAddon\App\Exports\ExportDue;

class AcnooDueReportController extends Controller
{
    public function index()
    {
        $total_due = Party::where('business_id', auth()->user()->business_id)->where('type', '!=', 'Supplier')->where('due', '>', 0)->sum('due');
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type', '!=', 'Supplier')->where('due', '>', 0)->latest()->paginate(20);
        
        return view('businessAddon::reports.due.due-reports', compact('due_lists','total_due'));
    }

    public function acnooFilter(Request $request)
    {
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type', '!=', 'Supplier')->where('due', '>', 0)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('type', 'like', '%' . $request->search . '%')
                      ->orwhere('name', 'like', '%' . $request->search . '%')
                      ->orwhere('phone', 'like', '%' . $request->search . '%')
                      ->orwhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::reports.due.datas', compact('due_lists'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type', '!=', 'Supplier')->where('due', '>', 0)->latest()->get();
        return view('businessAddon::reports.due.pdf', compact('due_lists'));
        $pdf = Pdf::loadview('businessAddon::reports.due.pdf', compact('due_lists'));
        return $pdf->download('customer.due.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportDue, 'customer-due.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportDue, 'customer-due.csv');
    }
}
