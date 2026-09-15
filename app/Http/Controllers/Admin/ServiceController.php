<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $services = Service::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search').'%';
                $query->where(function ($q) use ($term) {
                    $q->where('title', 'like', $term)
                        ->orWhere('short_description', 'like', $term);
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status') === 'published'))
            ->when($request->filled('featured'), fn ($query) => $query->where('featured', $request->input('featured') === 'yes'))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service();

        return view('admin.services.create', compact('service'));
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        $data = $this->prepare($request);
        $data['featured_image'] = $this->storeUploadedImage($request, 'featured_image', 'services');

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $this->prepare($request);

        if ($image = $this->storeUploadedImage($request, 'featured_image', 'services')) {
            $this->deleteStoredImage($service->featured_image);
            $data['featured_image'] = $image;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteStoredImage($service->featured_image);
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Service deleted.');
    }

    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update(['status' => ! $service->status]);

        return back()->with('status', $service->status ? 'Service published.' : 'Service unpublished.');
    }

    public function toggleFeatured(Service $service): RedirectResponse
    {
        $service->update(['featured' => ! $service->featured]);

        return back()->with('status', $service->featured ? 'Service marked as featured.' : 'Service removed from featured.');
    }

    private function prepare(ServiceRequest $request): array
    {
        $data = $request->safe()->except('featured_image');
        $data['featured'] = $request->boolean('featured');
        $data['status'] = $request->boolean('status');
        // Fall back to the title here (rather than relying on the model's
        // slug mutator to see $this->title, which depends on attribute
        // assignment order) — the mutator still runs Str::slug() on it.
        $data['slug'] = ($data['slug'] ?? null) ?: $data['title'];

        return $data;
    }
}
