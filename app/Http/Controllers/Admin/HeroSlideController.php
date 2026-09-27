<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlideRequest;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;

class HeroSlideController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $heroSlides = HeroSlide::ordered()->get();

        return view('admin.hero-slides.index', compact('heroSlides'));
    }

    public function create()
    {
        $heroSlide = new HeroSlide();

        return view('admin.hero-slides.create', compact('heroSlide'));
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['image'] = $this->storeUploadedImage($request, 'image', 'hero-slides');

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide added.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(HeroSlideRequest $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($image = $this->storeUploadedImage($request, 'image', 'hero-slides')) {
            $this->deleteStoredImage($heroSlide->image);
            $data['image'] = $image;
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        $this->deleteStoredImage($heroSlide->image);
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide deleted.');
    }
}
