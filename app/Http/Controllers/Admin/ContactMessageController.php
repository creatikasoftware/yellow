<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'unread') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('status', 'Message deleted.');
    }
}
