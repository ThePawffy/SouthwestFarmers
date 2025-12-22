<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\BusinessAddon\App\Exports\ExportStock;

class AcnooStockReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;

        $total_stock_value = Stock::whereHas('product', function ($q) use ($businessId) {
            $q->where('business_id', $businessId);
        })->sum(DB::raw('productPurchasePrice * productStock'));

        $total_qty = Stock::whereHas('product', function ($q) use ($businessId) {
            $q->where('business_id', $businessId);
        })->sum('productStock');

        $stocks = Product::with(['category:id,categoryName'])
            ->withSum('stocks', 'productStock')
            ->where('business_id', $businessId)
            ->latest()
            ->paginate(20);
            
        return view('businessAddon::reports.stocks.stock-reports', compact('stocks','total_stock_value','total_qty'));
    }

    public function acnooFilter(Request $request)
    {
        $stocks = Product::where('business_id', auth()->user()->business_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                    ->orwhere('productStock', 'like', '%' . $request->search . '%')
                    ->orwhere('productSalePrice', 'like', '%' . $request->search . '%')
                    ->orwhere('productPurchasePrice', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('categoryName', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::reports.stocks.datas', compact('stocks'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $stocks = Product::where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadview('businessAddon::reports.stocks.pdf', compact('stocks'));
        return $pdf->download('reports.stocks.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportStock, 'stock.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportStock, 'stock.csv');
    }

}
