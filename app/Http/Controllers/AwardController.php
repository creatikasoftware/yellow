<?php

namespace App\Http\Controllers;

use App\Models\Award;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::ordered()->get();

        return view('frontend.awards.index', compact('awards'));
    }

    public function show(Award $award)
    {
        return view('frontend.awards.show', compact('award'));
    }
}
