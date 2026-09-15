<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $testimonial = new Testimonial();

        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('photo');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['photo'] = $this->storeUploadedImage($request, 'photo', 'testimonials');

        $testimonial = Testimonial::create($data);
        $this->enforceSingleFeatured($testimonial);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->safe()->except('photo');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($photo = $this->storeUploadedImage($request, 'photo', 'testimonials')) {
            $this->deleteStoredImage($testimonial->photo);
            $data['photo'] = $photo;
        }

        $testimonial->update($data);
        $this->enforceSingleFeatured($testimonial);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteStoredImage($testimonial->photo);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial deleted.');
    }

    /**
     * The homepage shows exactly one featured testimonial. If this one was
     * just marked featured, unmark any others so the "featured" flag stays
     * unique.
     */
    private function enforceSingleFeatured(Testimonial $testimonial): void
    {
        if ($testimonial->is_featured) {
            Testimonial::whereKeyNot($testimonial->id)->update(['is_featured' => false]);
        }
    }
}
