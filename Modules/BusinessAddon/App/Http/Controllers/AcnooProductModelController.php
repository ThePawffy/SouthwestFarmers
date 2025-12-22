<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class AcnooProductModelController extends Controller
{
    public function index()
    {
        $models = ProductModel::where('business_id', auth()->user()->business_id)->latest()->paginate(10);
        return view('businessAddon::product-models.index', compact('models'));
    }

    public function acnooFilter(Request $request)
    {
        $models = ProductModel::where('business_id', auth()->user()->business_id)->when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('businessAddon::product-models.datas', compact('models'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'name' => ['required', 'string', 'max:255', 'unique:product_models,name,NULL,id,business_id,' . auth()->user()->business_id],
        ]);

        ProductModel::create($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message'   => __('Model saved successfully'),
            'redirect'  => route('business.product-models.index')
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = ProductModel::where('business_id', auth()->user()->business_id)->findOrFail($id);

        $request->validate([
            'status' => 'required|boolean',
            'name' => ['required', 'string', 'max:255', 'unique:product_models,name,' . $model->id . ',id,business_id,' . auth()->user()->business_id],
        ]);

        $model->update($request->except('business_id'));

        return response()->json([
            'message'   => __('Model updated successfully'),
            'redirect'  => route('business.product-models.index')
        ]);
    }

    public function destroy($id)
    {
        ProductModel::where('business_id', auth()->user()->business_id)->where('id', $id)->delete();

        return response()->json([
            'message'   => __('Model deleted successfully'),
            'redirect'  => route('business.product-models.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        ProductModel::where('business_id', auth()->user()->business_id)->whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Selected model deleted successfully'),
            'redirect'  => route('business.product-models.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $model = ProductModel::findOrFail($id);
        $model->update(['status' => $request->status]);

        return response()->json(['message' => __('Model')]);
    }
}
