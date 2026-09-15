<?php

namespace App\Http\Controllers;

use App\Support\PageContent;

class PageController extends Controller
{
    public function about()
    {
        $content = PageContent::get('about');

        return view('frontend.about', compact('content'));
    }
}
