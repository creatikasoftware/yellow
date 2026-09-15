<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Registration;
use App\Models\Speaker;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'events' => Event::count(),
            'awards' => Award::count(),
            'speakers' => Speaker::count(),
            'gallery_items' => GalleryItem::count(),
            'news_articles' => NewsArticle::count(),
            'partners' => Partner::count(),
            'testimonials' => Testimonial::count(),
            'registrations' => Registration::count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
        ];

        $recentRegistrations = Registration::with('event')->latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'recentMessages'));
    }
}
