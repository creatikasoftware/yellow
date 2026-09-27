<?php

namespace App\Http\Controllers;

use App\Models\Award;

class AwardController extends Controller
{
    public function index()
    {
        $ourAwards = Award::section('our_awards')->ordered()->get();
        $ourCategories = Award::section('our_categories')->ordered()->get();

        return view('frontend.awards.index', compact('ourAwards', 'ourCategories'));
    }

    public function show(Award $award)
    {
        return view('frontend.awards.show', compact('award'));
    }
}
