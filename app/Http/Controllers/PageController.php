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

    public function privacyPolicy()
    {
        $content = PageContent::get('privacy');

        return view('frontend.privacy-policy', compact('content'));
    }

    public function termsConditions()
    {
        $content = PageContent::get('terms');

        return view('frontend.terms-conditions', compact('content'));
    }
}
