<?php

namespace Modules\BusinessAddon\App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExpense implements FromView
{
    public function view(): View
    {
        return view('businessAddon::reports.expense.excel-csv', [
            'expense_reports' => Expense::with('category:id,categoryName')->where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }
}
