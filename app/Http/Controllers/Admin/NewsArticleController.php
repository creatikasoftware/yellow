<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsArticleRequest;
use App\Models\NewsArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class NewsArticleController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $articles = NewsArticle::orderByDesc('published_at')->paginate(15);

        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        $newsArticle = new NewsArticle();

        return view('admin.news.create', compact('newsArticle'));
    }

    public function store(NewsArticleRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title']);
        $data['image'] = $this->storeUploadedImage($request, 'image', 'news');

        NewsArticle::create($data);

        return redirect()->route('admin.news.index')->with('status', 'Article created.');
    }

    public function edit(NewsArticle $newsArticle)
    {
        return view('admin.news.edit', compact('newsArticle'));
    }

    public function update(NewsArticleRequest $request, NewsArticle $newsArticle): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title']);

        if ($image = $this->storeUploadedImage($request, 'image', 'news')) {
            $this->deleteStoredImage($newsArticle->image);
            $data['image'] = $image;
        }

        $newsArticle->update($data);

        return redirect()->route('admin.news.index')->with('status', 'Article updated.');
    }

    public function destroy(NewsArticle $newsArticle): RedirectResponse
    {
        $this->deleteStoredImage($newsArticle->image);
        $newsArticle->delete();

        return redirect()->route('admin.news.index')->with('status', 'Article deleted.');
    }
}
