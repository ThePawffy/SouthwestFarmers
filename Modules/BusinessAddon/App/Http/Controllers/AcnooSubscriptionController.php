<?php

namespace Modules\BusinessAddon\App\Http\Controllers;

use App\Models\Plan;
use App\Http\Controllers\Controller;

class AcnooSubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::where('status', 1)->latest()->get();
        return view('businessAddon::subscriptions.index', compact('plans'));
    }
}
