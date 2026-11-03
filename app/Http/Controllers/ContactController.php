<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $content = PageContent::get('contact');
        $site = PageContent::get('site');

        return view('frontend.contact', compact('content', 'site'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        // The enquiry is already saved above regardless of what happens here,
        // so a mail outage never blocks the visitor's submission — just log
        // it for follow-up.
        try {
            Mail::to(config('mail.contact_recipient'))->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            Log::error('Failed to send contact enquiry email: ' . $e->getMessage());
        }

        return back()->with('status', "Thanks for reaching out — we'll get back to you shortly.");
    }
}
