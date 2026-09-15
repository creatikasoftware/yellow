<?php

namespace App\Http\Controllers;

use App\Models\Speaker;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::ordered()->get();

        return view('frontend.speakers.index', compact('speakers'));
    }

    public function show(Speaker $speaker)
    {
        return view('frontend.speakers.show', compact('speaker'));
    }
}
