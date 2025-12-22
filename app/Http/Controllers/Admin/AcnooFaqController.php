<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AcnooFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->paginate(20);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function acnooFilter(Request $request)
    {
        $faqs = Faq::when(request('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('question', 'like', '%' . $request->search . '%')
                        ->orWhere('answer', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.faqs.datas', compact('faqs'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|max:1000',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return response()->json([
            'message' => __('Faq created cuccessfully'),
            'redirect' => route('admin.faqs.index'),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|max:1000',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return response()->json([
            'message' => __('Faq updated successfully'),
            'redirect' => route('admin.faqs.index'),
        ]);
    }

    public function destroy(string $id)
    {
        Faq::where('id', $id)->delete();

        return response()->json([
            'message' => __('Faq deleted successfully'),
            'redirect' => route('admin.faqs.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Faq::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('Selected faq deleted successfully'),
            'redirect' => route('admin.faqs.index')
        ]);
    }

    public function status(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['status' => $request->status]);
        return response()->json(['message' => __('Faq')]);
    }
}
