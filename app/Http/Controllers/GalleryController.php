<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::ordered()->get();
        $featuredItem = $items->firstWhere('is_featured', true) ?? $items->first();
        $otherItems = $items->reject(fn ($item) => $featuredItem && $item->is($featuredItem))->values();

        return view('frontend.gallery.index', compact('featuredItem', 'otherItems'));
    }
}
