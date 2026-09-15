<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with('event')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'rejected'])],
        ]);

        $registration->update($data);

        return back()->with('status', 'Registration status updated.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('status', 'Registration deleted.');
    }
}
