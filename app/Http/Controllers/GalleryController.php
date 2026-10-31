<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GalleryController extends Controller
{
    /**
     * How many of $otherItems are rendered server-side on first load
     * (beyond the 4 already shown next to the large featured tile).
     * Everything past this is fetched via loadMore() as the visitor scrolls.
     */
    private const INITIAL_BATCH = 12;

    private const PER_PAGE = 12;

    public function index(Request $request)
    {
        $categories = GalleryCategory::ordered()->get();
        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        [$featuredItem, $otherItems] = $this->fetchItems($activeCategory);

        $heroCount = $featuredItem ? 4 : 0;
        $shownCount = $heroCount + self::INITIAL_BATCH;
        $hasMore = $otherItems->count() > $shownCount;

        return view('frontend.gallery.index', compact(
            'categories', 'activeCategory', 'featuredItem', 'otherItems', 'shownCount', 'hasMore'
        ));
    }

    public function loadMore(Request $request): JsonResponse
    {
        $categories = GalleryCategory::ordered()->get();
        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        [, $otherItems] = $this->fetchItems($activeCategory);

        $offset = max(0, (int) $request->query('offset', 0));
        $page = $otherItems->slice($offset, self::PER_PAGE)->values();
        $hasMore = ($offset + self::PER_PAGE) < $otherItems->count();

        return response()->json([
            'html' => view('frontend.gallery._cards', ['items' => $page])->render(),
            'hasMore' => $hasMore,
            'nextOffset' => $offset + self::PER_PAGE,
        ]);
    }

    /**
     * @return array{0: ?GalleryItem, 1: Collection<int, GalleryItem>}
     */
    private function fetchItems(?GalleryCategory $activeCategory): array
    {
        $items = GalleryItem::ordered()
            ->when($activeCategory, fn ($query) => $query->where('category_id', $activeCategory->id))
            ->get();

        $featuredItem = $items->firstWhere('is_featured', true);
        $otherItems = $items->reject(fn ($item) => $featuredItem && $item->is($featuredItem))->values();

        return [$featuredItem, $otherItems];
    }
}
