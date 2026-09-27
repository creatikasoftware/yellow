<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Support\PageContent;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::published()->upcoming()->orderBy('starts_at')->get();
        $pastEvents = Event::published()->past()->orderByDesc('starts_at')->get();
        $featuredEvent = Event::published()->where('is_featured', true)->first();
        $content = PageContent::get('home');

        return view('frontend.events.index', compact('upcomingEvents', 'pastEvents', 'featuredEvent', 'content'));
    }

    public function show(Event $event)
    {
        abort_if($event->status !== 'published', 404);

        $event->load('agendaItems');

        return view('frontend.events.show', compact('event'));
    }
}
