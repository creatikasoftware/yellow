<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::published()->upcoming()->orderBy('starts_at')->get();
        $pastEvents = Event::published()->past()->orderByDesc('starts_at')->get();

        return view('frontend.events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function show(Event $event)
    {
        abort_if($event->status !== 'published', 404);

        $event->load('agendaItems');

        return view('frontend.events.show', compact('event'));
    }
}
