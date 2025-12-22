<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AcnooCategoryController extends Controller
{
    use HasUploader;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('📥 Category index called', [
            'user_id' => auth()->id(),
            'business_id' => auth()->user()->business_id ?? null,
        ]);

        $data = Category::where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        Log::info('✅ Categories fetched', [
            'count' => $data->count(),
        ]);

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('📤 Category store request received', [
            'user_id' => auth()->id(),
            'business_id' => auth()->user()->business_id ?? null,
            'fields' => $request->except(['icon']),
            'has_icon' => $request->hasFile('icon'),
        ]);

        $business_id = auth()->user()->business_id;

        try {
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');

                Log::info('🧪 Upload debug', [
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage(),
                    'size_kb' => $file->getSize() / 1024,
                    'mime' => $file->getMimeType(),
                ]);
            }
            $request->validate([
                'categoryName' => 'required|unique:categories,categoryName,NULL,id,business_id,' . $business_id,
                'icon' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            ]);

            Log::info('✅ Validation passed');
        } catch (\Throwable $e) {
            Log::error('❌ Validation failed', [
                'errors' => $e->getMessage(),
            ]);
            throw $e;
        }

        try {
            $iconPath = null;

            if ($request->hasFile('icon')) {
                Log::info('🖼️ Uploading category icon');
                $iconPath = $this->upload($request, 'icon');
            }

            $data = Category::create([
                'business_id' => $business_id,
                'categoryName' => $request->categoryName,
                'variationCapacity' => $request->variationCapacity === 'true' ? 1 : 0,
                'variationColor' => $request->variationColor === 'true' ? 1 : 0,
                'variationSize' => $request->variationSize === 'true' ? 1 : 0,
                'variationType' => $request->variationType === 'true' ? 1 : 0,
                'variationWeight' => $request->variationWeight === 'true' ? 1 : 0,
                'icon' => $iconPath,
            ]);

            Log::info('✅ Category created successfully', [
                'category_id' => $data->id,
                'icon_path' => $iconPath,
            ]);

            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $data,
            ], 201);

        } catch (\Throwable $e) {
            Log::error('🔥 Category creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'The icon failed to upload.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Log::info('✏️ Category update request', [
            'category_id' => $category->id,
            'has_icon' => $request->hasFile('icon'),
        ]);

        $request->validate([
            'categoryName' => [
                'required',
                'unique:categories,categoryName,' . $category->id . ',id,business_id,' . auth()->user()->business_id,
            ],
            'icon' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        $iconPath = $category->icon;

        if ($request->hasFile('icon')) {
            Log::info('🔄 Updating category icon', [
                'old_icon' => $category->icon,
            ]);
            $iconPath = $this->upload($request, 'icon', $category->icon);
        }

        $category->update([
            'categoryName' => $request->categoryName,
            'variationCapacity' => $request->variationCapacity === 'true' ? 1 : 0,
            'variationColor' => $request->variationColor === 'true' ? 1 : 0,
            'variationSize' => $request->variationSize === 'true' ? 1 : 0,
            'variationType' => $request->variationType === 'true' ? 1 : 0,
            'variationWeight' => $request->variationWeight === 'true' ? 1 : 0,
            'icon' => $iconPath,
        ]);

        Log::info('✅ Category updated successfully', [
            'category_id' => $category->id,
        ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Log::info('🗑️ Category delete request', [
            'category_id' => $category->id,
        ]);

        $category->delete();

        Log::info('✅ Category deleted', [
            'category_id' => $category->id,
        ]);

        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}