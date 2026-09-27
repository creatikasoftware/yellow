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
        // The standalone registration page's event dropdown can also list
        // the featured event, so the CV requirement is scoped to the
        // featured-event widget form itself (via this hidden flag) rather
        // than to which event was selected — otherwise a standalone-page
        // submission for that same event would fail validation with no CV
        // field available to satisfy it.
        $cvRequired = $request->boolean('cv_required');

        $event = $request->filled('event_slug')
            ? Event::where('slug', $request->input('event_slug'))->first()
            : null;

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
            'photo' => ['nullable', 'image', 'max:4096'],
            'cv' => [$cvRequired ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'agreed_terms' => ['nullable', 'boolean'],
        ]);

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('registrations', 'public')
            : null;

        $cvPath = $request->hasFile('cv')
            ? $request->file('cv')->store('registrations/cv', 'public')
            : null;

        Registration::create([
            ...collect($validated)->except(['event_slug', 'photo', 'cv'])->toArray(),
            'event_id' => $event?->id,
            'photo' => $photoPath,
            'cv' => $cvPath,
            'agreed_terms' => $request->boolean('agreed_terms'),
            'source' => $event?->is_featured ? 'homepage_widget' : 'registration_page',
        ]);

        return back()->with('status', 'Thank you — your registration has been received. Our team will confirm within 24 hours.');
    }
}
