<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $events = Event::published()->orderBy('starts_at')->get();

        return view('frontend.registration', compact('events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'organization' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'registration_type' => ['nullable', 'string', 'max:255'],
            'event_slug' => ['nullable', 'string', 'exists:events,slug'],
            'message' => ['nullable', 'string', 'max:5000'],
            'agreed_terms' => ['nullable', 'boolean'],
        ]);

        $event = isset($validated['event_slug'])
            ? Event::where('slug', $validated['event_slug'])->first()
            : null;

        Registration::create([
            ...collect($validated)->except(['event_slug'])->toArray(),
            'event_id' => $event?->id,
            'agreed_terms' => $request->boolean('agreed_terms'),
            'source' => $event?->is_featured ? 'homepage_widget' : 'registration_page',
        ]);

        return back()->with('status', 'Thank you — your registration has been received. Our team will confirm within 24 hours.');
    }
}
