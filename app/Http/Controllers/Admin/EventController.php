<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $events = Event::orderBy('starts_at')->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $event = new Event();

        return view('admin.events.create', compact('event'));
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $data = $this->prepare($request);
        $data['image'] = $this->storeUploadedImage($request, 'image', 'events');

        $event = Event::create($data);
        $this->syncAgenda($event, $request);

        return redirect()->route('admin.events.index')->with('status', 'Event created.');
    }

    public function edit(Event $event)
    {
        $event->load('agendaItems');

        return view('admin.events.edit', compact('event'));
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $data = $this->prepare($request, $event);

        if ($image = $this->storeUploadedImage($request, 'image', 'events')) {
            $this->deleteStoredImage($event->image);
            $data['image'] = $image;
        }

        $event->update($data);
        $this->syncAgenda($event, $request);

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->deleteStoredImage($event->image);
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event deleted.');
    }

    private function prepare(EventRequest $request, ?Event $event = null): array
    {
        $data = $request->safe()->except(['image', 'agenda_time', 'agenda_title', 'agenda_description']);

        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title']);
        $data['highlights'] = ($data['highlights'] ?? null)
            ? array_values(array_filter(array_map('trim', explode("\n", $data['highlights']))))
            : null;
        $data['registration_open'] = $request->boolean('registration_open');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function syncAgenda(Event $event, EventRequest $request): void
    {
        $event->agendaItems()->delete();

        $times = $request->input('agenda_time', []);
        $titles = $request->input('agenda_title', []);
        $descriptions = $request->input('agenda_description', []);

        foreach ($titles as $index => $title) {
            if (blank($title)) {
                continue;
            }

            $event->agendaItems()->create([
                'time' => $times[$index] ?? '',
                'title' => $title,
                'description' => $descriptions[$index] ?? null,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
