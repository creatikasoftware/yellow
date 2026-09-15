<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AwardRequest;
use App\Models\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AwardController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $awards = Award::orderBy('sort_order')->paginate(15);

        return view('admin.awards.index', compact('awards'));
    }

    public function create()
    {
        $award = new Award();

        return view('admin.awards.create', compact('award'));
    }

    public function store(AwardRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['name']);
        $data['image'] = $this->storeUploadedImage($request, 'image', 'awards');

        Award::create($data);

        return redirect()->route('admin.awards.index')->with('status', 'Award category created.');
    }

    public function edit(Award $award)
    {
        return view('admin.awards.edit', compact('award'));
    }

    public function update(AwardRequest $request, Award $award): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['name']);

        if ($image = $this->storeUploadedImage($request, 'image', 'awards')) {
            $this->deleteStoredImage($award->image);
            $data['image'] = $image;
        }

        $award->update($data);

        return redirect()->route('admin.awards.index')->with('status', 'Award category updated.');
    }

    public function destroy(Award $award): RedirectResponse
    {
        $this->deleteStoredImage($award->image);
        $award->delete();

        return redirect()->route('admin.awards.index')->with('status', 'Award category deleted.');
    }
}
