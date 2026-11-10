<?php

namespace App\Http\Controllers;

use App\Mail\PartnerApplicationReceived;
use App\Models\PartnerApplication;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PartnerApplicationController extends Controller
{
    public function index()
    {
        $content = PageContent::get('partner');

        return view('frontend.partner', compact('content'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'city_country' => ['nullable', 'string', 'max:255'],
            'tier' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:5000'],
        ]);

        $partnerApplication = PartnerApplication::create($validated);

        // The application is already saved above regardless of what happens
        // here, so a mail outage never blocks the visitor's submission —
        // just log it for follow-up.
        try {
            Mail::to(config('mail.contact_recipient'))->send(new PartnerApplicationReceived($partnerApplication));
        } catch (\Throwable $e) {
            Log::error('Failed to send partner application email: ' . $e->getMessage());
        }

        return back()->with('status', "Thanks for applying — our partner team will review and respond within 48 hours.");
    }
}
