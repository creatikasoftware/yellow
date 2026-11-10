<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PartnerApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = PartnerApplication::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.partner-applications.index', compact('applications'));
    }

    public function show(PartnerApplication $partnerApplication)
    {
        if ($partnerApplication->status === 'new') {
            $partnerApplication->update(['status' => 'reviewed']);
        }

        return view('admin.partner-applications.show', compact('partnerApplication'));
    }

    public function update(Request $request, PartnerApplication $partnerApplication): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['new', 'reviewed', 'contacted', 'rejected'])],
        ]);

        $partnerApplication->update($data);

        return back()->with('status', 'Application status updated.');
    }

    public function destroy(PartnerApplication $partnerApplication): RedirectResponse
    {
        $partnerApplication->delete();

        return redirect()->route('admin.partner-applications.index')->with('status', 'Application deleted.');
    }
}
