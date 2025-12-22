<?php

namespace Modules\BusinessAddon\App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportProduct implements FromView
{
    public function view(): View
    {
        $products = Product::with('stocks', 'unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')
            ->where('business_id', auth()->user()->business_id)
            ->withSum('stocks as total_stock', 'productStock')
            ->latest()
            ->get();
        
        return view('businessAddon::products.excel-csv', compact('products'));
    }
}
