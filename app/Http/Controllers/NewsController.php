<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::published()->get();

        return view('frontend.news.index', compact('articles'));
    }

    public function show(NewsArticle $news)
    {
        return view('frontend.news.show', ['article' => $news]);
    }
}
