<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcnooTutorialController extends Controller
{
    use HasUploader;

    public function index()
    {
        $tutorials = Tutorial::latest()->paginate(20);
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function acnooFilter(Request $request)
    {
        $tutorials = Tutorial::when(request('search'), function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('url', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if($request->ajax()){
            return response()->json([
                'data' => view('admin.tutorials.datas',compact('tutorials'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Tutorial::create($request->except('thumbnail') + [
            'thumbnail' => $request->thumbnail ? $this->upload($request, 'thumbnail') : NULL
        ]);

        return response()->json([
            'message' => __('Tutorial created cuccessfully'),
            'redirect' => route('admin.tutorials.index'),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tutorial = Tutorial::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $tutorial->update($request->except('thumbnail') + [
            'thumbnail' => $request->thumbnail ? $this->upload($request, 'thumbnail', $tutorial->thumbnail) : $tutorial->thumbnail
        ]);

        return response()->json([
            'message' => __('Tutorial updated successfully'),
            'redirect' => route('admin.tutorials.index'),
        ]);
    }

    public function destroy(string $id)
    {
        $tutorial = Tutorial::findOrFail($id);

        if (file_exists($tutorial->thumbnail)) {
            Storage::delete($tutorial->thumbnail);
        }

        $tutorial->delete();

        return response()->json([
            'message' => __('Tutorial deleted successfully'),
            'redirect' => route('admin.tutorials.index')
        ]);
    }

    public function status(Request $request, string $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->update(['status' => $request->status]);
        return response()->json(['message' => __('Tutorial')]);
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();

        try {
            $tutorials = Tutorial::whereIn('id', $request->ids)->get();

            foreach ($tutorials as $tutorial) {
                if (file_exists($tutorial->thumbnail)) {
                    Storage::delete($tutorial->thumbnail);
                }

                $tutorial->delete();
            }

            DB::commit();

            return response()->json([
                'message' => __('Selected tutorial deleted successfully'),
                'redirect' => route('admin.tutorials.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }
}
