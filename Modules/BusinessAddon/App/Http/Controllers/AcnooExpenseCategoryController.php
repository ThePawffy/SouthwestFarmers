<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;

class AcnooExpenseCategoryController extends Controller
{
    public function index()
    {
        $expense_categories = ExpenseCategory::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('businessAddon::expense-categories.index', compact('expense_categories'));
    }

    public function acnooFilter(Request $request)
    {
        $expense_categories = ExpenseCategory::where('business_id', auth()->user()->business_id)
        ->when(request('search'), function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('categoryName', 'like', '%'.$request->search.'%')
                      ->orWhere('categoryDescription', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('businessAddon::expense-categories.datas',compact('expense_categories'))->render()
            ]);
        }
        return redirect(url()->previous());
    }


    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|unique:expense_categories,categoryName,NULL,id,business_id,' . auth()->user()->business_id,
        ]);

         ExpenseCategory::create($request->except('business_id') + [
                    'business_id' => auth()->user()->business_id,
                ]);

        return response()->json([
            'message' => __('Expense Category saved successfully.'),
            'redirect' => route('business.expense-categories.index')
        ]);
    }


    public function update(Request $request, string $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $request->validate([
            'categoryName' => [
                'required',
                'unique:expense_categories,categoryName,' . $category->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);

        $category->update($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Expense Category updated successfully.'),
            'redirect' => route('business.expense-categories.index')
        ]);
    }

    public function destroy(string $id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->delete();

        return response()->json([
            'message' => __('Expense Category deleted successfully'),
            'redirect' => route('business.expense-categories.index')
        ]);
    }

    public function status(Request $request, string $id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->update(['status' => $request->status]);
        return response()->json(['message' => __('Expense Category')]);
    }


    public function deleteAll(Request $request)
    {
        ExpenseCategory::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Selected item deleted successfully.'),
            'redirect' => route('business.expense-categories.index'),
        ]);
    }
}
