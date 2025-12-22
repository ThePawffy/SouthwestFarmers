<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\BusinessAddon\App\Exports\ExportExpiredProductReport;

class AcnooExpireProductReportController extends Controller
{
    public function index()
    {
        $expired_products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName','stocks')
            ->withSum('stocks', 'productStock')
            ->where('business_id', auth()->user()->business_id)
            ->whereHas('stocks', function ($query) {
                $query->whereDate('expire_date', '<', today())->where('productStock', '>', 0);
            })
            ->latest()
            ->paginate(20);

        return view('businessAddon::reports.expired-products.index', compact('expired_products'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $expiredProductsQuery = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName', 'stocks')
            ->where('business_id', $businessId)
            ->withSum('stocks', 'productStock')
            ->whereHas('stocks', function ($query) {
                $query->whereDate('expire_date', '<', today())->where('productStock', '>', 0);
            })
            ->where('expire_date', '<', now()->format('Y-m-d'));

        if ($request->has('custom_days')) {
            $startDate = $endDate = now()->format('Y-m-d'); // default today

            switch ($request->custom_days) {
                case 'yesterday':
                    $startDate = $endDate = Carbon::yesterday()->format('Y-m-d');
                    break;
                case 'last_seven_days':
                    $startDate = Carbon::today()->subDays(6)->format('Y-m-d');
                    break;
                case 'last_thirty_days':
                    $startDate = Carbon::today()->subDays(29)->format('Y-m-d');
                    break;
                case 'current_month':
                    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                    $endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                    break;
                case 'current_year':
                    $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
                    break;
                case 'custom_date':
                    if ($request->from_date && $request->to_date) {
                        $startDate = Carbon::parse($request->from_date)->format('Y-m-d');
                        $endDate = Carbon::parse($request->to_date)->format('Y-m-d');
                    }
                    break;
            }

            if (isset($startDate) && isset($endDate)) {
                $expiredProductsQuery->whereBetween('expire_date', [$startDate, $endDate]);
            }
        }

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $expiredProductsQuery->where(function ($query) use ($search) {
                $query->where('productName', 'like', "%{$search}%")
                    ->orWhere('productCode', 'like', "%{$search}%")
                    ->orWhere('productPurchasePrice', 'like', "%{$search}%")
                    ->orWhere('productSalePrice', 'like', "%{$search}%")
                    ->orWhere('productStock', 'like', "%{$search}%")
                    ->orWhereHas('category', fn($q) => $q->where('categoryName', 'like', "%{$search}%"))
                    ->orWhereHas('brand', fn($q) => $q->where('brandName', 'like', "%{$search}%"))
                    ->orWhereHas('unit', fn($q) => $q->where('unitName', 'like', "%{$search}%"));
            });
        }

        $perPage = $request->input('per_page', 10);
        $expired_products = $expiredProductsQuery->latest()->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::reports.expired-products.datas', compact('expired_products'))->render()
            ]);
        }

        return redirect()->back();
    }

    public function exportExcel()
    {
        return Excel::download(new ExportExpiredProductReport, 'expired-product-reports.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportExpiredProductReport, 'expired-product-reports.csv');
    }
}
