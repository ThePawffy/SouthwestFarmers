<?php

namespace Modules\BusinessAddon\App\Exports;

use App\Models\Purchase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PurchaseExport implements FromView
{
    public function view(): View
    {
        return view('businessAddon::reports.purchase.excel-csv', [
            'purchases' => Purchase::with('details','party','details.product','details.product.category')->where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }

}
