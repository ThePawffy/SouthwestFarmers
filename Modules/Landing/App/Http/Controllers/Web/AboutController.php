<?php

namespace Modules\Landing\App\Http\Controllers\Web;

use App\Models\Plan;
use App\Models\Option;
use App\Http\Controllers\Controller;
use Modules\Landing\App\Models\Feature;


class AboutController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        $features = Feature::whereStatus(1)->latest()->get();
        $plans = Plan::latest()->get();

        return view('landing::web.about.index',compact('page_data','general','features','plans'));
    }
}
