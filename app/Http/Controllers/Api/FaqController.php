<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $data = Faq::whereStatus(1)->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }
}
