<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Models\SpeakerCategory;

class SpeakerController extends Controller
{
    public function index()
    {
        $categories = SpeakerCategory::ordered()->get();
        $speakersByCategory = Speaker::ordered()->get()->groupBy('category_id');

        return view('frontend.speakers.index', compact('categories', 'speakersByCategory'));
    }

    public function show(Speaker $speaker)
    {
        return view('frontend.speakers.show', compact('speaker'));
    }
}
