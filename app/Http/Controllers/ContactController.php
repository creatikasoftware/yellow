<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        ContactMessage::create($validated);

        return back()->with('status', "Thanks for reaching out — we'll get back to you shortly.");
    }
}
