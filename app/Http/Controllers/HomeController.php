<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Speaker;
use App\Models\SpeakerCategory;
use App\Models\Testimonial;
use App\Support\PageContent;

class HomeController extends Controller
{
    public function index()
    {
        $content = PageContent::get('home');
        // Featured events are promised a spot ("Feature on homepage" in the
        // admin), so they're sorted ahead of the merely-soonest ones here.
        $events = Event::published()->upcoming()->orderByDesc('is_featured')->orderBy('starts_at')->take(3)->get();
        $awards = Award::ordered()->take(6)->get();
        // Once an admin flags one or more categories "Show on homepage", only
        // those speakers appear here. Until then (no category configured
        // yet), fall back to the top speakers overall.
        $homeFeaturedCategoryIds = SpeakerCategory::where('is_home_featured', true)->pluck('id');
        $speakers = $homeFeaturedCategoryIds->isNotEmpty()
            ? Speaker::whereIn('category_id', $homeFeaturedCategoryIds)->ordered()->take(4)->get()
            : Speaker::ordered()->take(4)->get();
        $allGalleryItems = GalleryItem::ordered()->get();
        $featuredGalleryItem = $allGalleryItems->firstWhere('is_featured', true);
        $otherGalleryItems = $allGalleryItems->reject(fn ($item) => $featuredGalleryItem && $item->is($featuredGalleryItem))->values();
        $testimonials = Testimonial::ordered()->get();
        $featuredTestimonial = $testimonials->firstWhere('is_featured', true);
        $smallTestimonials = $testimonials->where('is_featured', false)->values();
        $partners = Partner::ordered()->get();
        $featuredEvent = Event::published()->where('is_featured', true)->first();

        return view('frontend.home', [
            'content' => $content,
            'events' => $events,
            'awards' => $awards,
            'speakers' => $speakers,
            'featuredGalleryItem' => $featuredGalleryItem,
            'otherGalleryItems' => $otherGalleryItems,
            'featuredTestimonial' => $featuredTestimonial,
            'smallTestimonials' => $smallTestimonials,
            'partners' => $partners,
            'featuredEvent' => $featuredEvent,
            'homeStats' => json_decode(Setting::get('home.stats', '[]'), true),
            'trustStats' => json_decode(Setting::get('testimonials.trust_stats', '[]'), true),
            'extended' => true,
            'footerAwards' => Award::ordered()->take(4)->get(),
        ]);
    }
}
