<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpeakerRequest;
use App\Models\Speaker;
use App\Models\SpeakerCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SpeakerController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $speakers = Speaker::with('category')->orderBy('sort_order')->paginate(15);

        return view('admin.speakers.index', compact('speakers'));
    }

    public function create()
    {
        $speaker = new Speaker();
        $categories = SpeakerCategory::ordered()->pluck('name', 'id');

        return view('admin.speakers.create', compact('speaker', 'categories'));
    }

    public function store(SpeakerRequest $request): RedirectResponse
    {
        $data = $this->prepare($request);
        $data['photo'] = $this->storeUploadedImage($request, 'photo', 'speakers');

        Speaker::create($data);

        return redirect()->route('admin.speakers.index')->with('status', 'Speaker created.');
    }

    public function edit(Speaker $speaker)
    {
        $categories = SpeakerCategory::ordered()->pluck('name', 'id');

        return view('admin.speakers.edit', compact('speaker', 'categories'));
    }

    public function update(SpeakerRequest $request, Speaker $speaker): RedirectResponse
    {
        $data = $this->prepare($request);

        if ($photo = $this->storeUploadedImage($request, 'photo', 'speakers')) {
            $this->deleteStoredImage($speaker->photo);
            $data['photo'] = $photo;
        }

        $speaker->update($data);

        return redirect()->route('admin.speakers.index')->with('status', 'Speaker updated.');
    }

    public function destroy(Speaker $speaker): RedirectResponse
    {
        $this->deleteStoredImage($speaker->photo);
        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('status', 'Speaker deleted.');
    }

    private function prepare(SpeakerRequest $request): array
    {
        $data = $request->safe()->except('photo');
        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['name']);
        $data['expertise'] = ($data['expertise'] ?? null)
            ? array_values(array_filter(array_map('trim', explode("\n", $data['expertise']))))
            : null;

        return $data;
    }
}
