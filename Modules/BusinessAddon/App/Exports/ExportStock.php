<?php

namespace Modules\BusinessAddon\App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportStock implements FromView
{
    public function view(): View
    {
        return view('businessAddon::reports.stocks.excel-csv', [
            'stocks' => Product::where('business_id', auth()->user()->business_id)->withSum('stocks', 'productStock')->latest()->get()
        ]);
    }
}
