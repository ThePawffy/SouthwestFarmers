<?php

namespace Modules\BusinessAddon\App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportLossProfit implements FromView
{
    public function view(): View
    {
        return view('businessAddon::reports.loss-profits.excel-csv', [
            'loss_profits' => Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('saleDate', Carbon::now()->year)->latest()->get()
        ]);
    }
}
