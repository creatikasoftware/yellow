<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryCategoryRequest;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $galleryCategories = GalleryCategory::withCount('galleryItems')->ordered()->get();

        return view('admin.gallery-categories.index', compact('galleryCategories'));
    }

    public function create()
    {
        $galleryCategory = new GalleryCategory();

        return view('admin.gallery-categories.create', compact('galleryCategory'));
    }

    public function store(GalleryCategoryRequest $request): RedirectResponse
    {
        GalleryCategory::create($request->validated());

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Category added.');
    }

    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    public function update(GalleryCategoryRequest $request, GalleryCategory $galleryCategory): RedirectResponse
    {
        $galleryCategory->update($request->validated());

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Category updated.');
    }

    public function destroy(GalleryCategory $galleryCategory): RedirectResponse
    {
        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Category deleted.');
    }
}
