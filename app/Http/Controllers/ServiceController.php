<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::published()->ordered()->paginate(9)->withQueryString();

        return view('frontend.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        // Route-model binding resolves by slug (Service::getRouteKeyName())
        // regardless of status, so an unpublished service must be rejected
        // here rather than left publicly reachable by a guessed URL.
        abort_unless($service->status, 404);

        $relatedServices = Service::published()
            ->whereKeyNot($service->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('frontend.services.show', compact('service', 'relatedServices'));
    }
}
