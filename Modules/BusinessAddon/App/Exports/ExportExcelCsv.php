<?php

namespace Modules\BusinessAddon\App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExcelCsv implements FromView
{
    public function view(): View
    {
        return view('businessAddon::reports.sales.excel', [
            'sales' => Sale::with('user:id,name', 'party:id,name,email,phone,type')
                            ->where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }
}
