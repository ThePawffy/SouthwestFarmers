<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return redirect()->back()->with('error', 'You have no permission to access.');
        }

        $stocks = Product::where('business_id', auth()->user()->business_id)
            ->whereColumn('productStock', '<=', 'alert_qty')
            ->latest()
            ->take(5)
            ->get();

        $top_products = DB::table('sale_details')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->where('sales.business_id', auth()->user()->business_id)
            ->select(
                'products.id',
                'products.productName',
                'products.productPicture',
                'sale_details.price',
                DB::raw('SUM(sale_details.quantities) as total_quantity')
            )
            ->groupBy(
                'products.id',
                'products.productName',
                'products.productPicture',
                'sale_details.price'
            )
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $top_customers = DB::table('sales')
            ->join('parties', 'sales.party_id', '=', 'parties.id')
            ->select(
                'parties.id',
                'parties.name',
                'parties.phone',
                'parties.image',
                DB::raw('COUNT(sales.id) as total_sales'),
                DB::raw('SUM(sales.actual_total_amount) as total_amount')
            )
            ->where('sales.business_id', auth()->user()->business_id)
            ->whereMonth('sales.saleDate', Carbon::now()->month)
            ->whereYear('sales.saleDate', Carbon::now()->year)
            ->groupBy(
                'parties.id',
                'parties.name',
                'parties.phone',
                'parties.image',
            )
            ->orderByDesc('total_sales', 'total_amount')
            ->limit(5)
            ->get();


        return view('businessAddon::dashboard.index', compact('stocks', 'top_products', 'top_customers'));
    }

    public function getDashboardData(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $range = $request->input('range', '7d');
        $query = now();

        switch ($range) {
            case '12m':
                $query = now()->subMonths(12);
                break;
            case '30d':
                $query = now()->subDays(30);
                break;
            case '7d':
                $query = now()->subDays(7);
                break;
            case 'all':
                $query = null;
                break;
        }

        $data['total_sales'] = currency_format(
            Sale::where('business_id', $businessId)
                ->when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where('saleDate', '>=', $query);
                })
                ->sum('totalAmount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['today_sales'] = currency_format(
            Sale::where('business_id', $businessId)
                ->whereDate('saleDate', today())
                ->sum('totalAmount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['total_purchases'] = currency_format(
            Purchase::where('business_id', $businessId)
                ->when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where('purchaseDate', '>=', $query);
                })
                ->sum('totalAmount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['today_purchases'] = currency_format(
            Purchase::where('business_id', $businessId)
                ->whereDate('purchaseDate', today())
                ->sum('totalAmount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['total_income'] = currency_format(
            Income::where('business_id', $businessId)
                ->when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where('incomeDate', '>=', $query);
                })
                ->sum('amount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['today_income'] = currency_format(
            Income::where('business_id', $businessId)
                ->whereDate('incomeDate', today())
                ->sum('amount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['total_expense'] = currency_format(
            Expense::where('business_id', $businessId)
                ->when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where('expenseDate', '>=', $query);
                })
                ->sum('amount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        $data['today_expense'] = currency_format(
            Expense::where('business_id', $businessId)
                ->whereDate('expenseDate', today())
                ->sum('amount'),
            currency:
            business_currency(),
            abbreviate: true
        );

        return response()->json($data);
    }

    public function salesPurchases(Request $request)
    {
        $range = $request->input('range', '7d');

        $query = Sale::where('business_id', auth()->user()->business_id);

        if ($range == '7d') {
            $query->where('saleDate', '>=', now()->subDays(7));
        } elseif ($range == '30d') {
            $query->where('saleDate', '>=', now()->subDays(30));
        } elseif ($range == '12m') {
            $query->where('saleDate', '>=', now()->subMonths(12));
        }

        $data['sales'] = $query
            ->selectRaw('MONTHNAME(saleDate) as month, SUM(ABS(totalAmount)) as total')
            ->groupBy('saleDate')
            ->orderBy('saleDate')
            ->get();

        $query = Purchase::where('business_id', auth()->user()->business_id);

        if ($range == '7d') {
            $query->where('purchaseDate', '>=', now()->subDays(7));
        } elseif ($range == '30d') {
            $query->where('purchaseDate', '>=', now()->subDays(30));
        } elseif ($range == '12m') {
            $query->where('purchaseDate', '>=', now()->subMonths(12));
        }

        $data['purchases'] = $query
            ->selectRaw('MONTHNAME(purchaseDate) as month, SUM(ABS(totalAmount)) as total')
            ->groupBy('purchaseDate')
            ->orderBy('purchaseDate')
            ->get();

        return response()->json($data);
    }

    public function earningData()
    {
        $businessId = auth()->user()->business_id;
        $range = request('range', '7d');

        $incomeQuery = Income::where('business_id', $businessId);
        $expenseQuery = Expense::where('business_id', $businessId);

        switch ($range) {
            case '12m':
                $from = now()->subMonths(12)->startOfMonth();
                $groupFormat = '%Y-%m';
                break;
            case '30d':
            case '7d':
                $from = now()->subDays($range === '30d' ? 30 : 7)->startOfDay();
                $groupFormat = '%Y-%m-%d';
                break;
            case 'all':
            default:
                $from = null;
                $groupFormat = '%Y-%m';
                break;
        }

        if ($from) {
            $incomeQuery->where('incomeDate', '>=', $from);
            $expenseQuery->where('expenseDate', '>=', $from);
        }

        $data['incomes'] = $incomeQuery
            ->selectRaw("DATE_FORMAT(incomeDate, '{$groupFormat}') as period, SUM(ABS(amount)) as total")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $data['expenses'] = $expenseQuery
            ->selectRaw("DATE_FORMAT(expenseDate, '{$groupFormat}') as period, SUM(ABS(amount)) as total")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json($data);
    }
}
