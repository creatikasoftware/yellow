<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categories = GalleryCategory::ordered()->get();
        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        $items = GalleryItem::ordered()
            ->when($activeCategory, fn ($query) => $query->where('category_id', $activeCategory->id))
            ->get();

        $featuredItem = $items->firstWhere('is_featured', true);
        $otherItems = $items->reject(fn ($item) => $featuredItem && $item->is($featuredItem))->values();

        return view('frontend.gallery.index', compact('categories', 'activeCategory', 'featuredItem', 'otherItems'));
    }
}
