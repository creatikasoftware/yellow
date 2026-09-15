<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryItemRequest;
use App\Models\Event;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;

class GalleryItemController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $galleryItems = GalleryItem::with('event')->orderBy('sort_order')->paginate(20);

        return view('admin.gallery.index', compact('galleryItems'));
    }

    public function create()
    {
        $galleryItem = new GalleryItem();
        $events = Event::orderBy('title')->pluck('title', 'id');

        return view('admin.gallery.create', compact('galleryItem', 'events'));
    }

    public function store(GalleryItemRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['image'] = $this->storeUploadedImage($request, 'image', 'gallery');
        $data['is_featured'] = $request->boolean('is_featured');

        GalleryItem::create($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item added.');
    }

    public function edit(GalleryItem $galleryItem)
    {
        $events = Event::orderBy('title')->pluck('title', 'id');

        return view('admin.gallery.edit', compact('galleryItem', 'events'));
    }

    public function update(GalleryItemRequest $request, GalleryItem $galleryItem): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($image = $this->storeUploadedImage($request, 'image', 'gallery')) {
            $this->deleteStoredImage($galleryItem->image);
            $data['image'] = $image;
        }

        $galleryItem->update($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $galleryItem): RedirectResponse
    {
        $this->deleteStoredImage($galleryItem->image);
        $galleryItem->delete();

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item deleted.');
    }
}
