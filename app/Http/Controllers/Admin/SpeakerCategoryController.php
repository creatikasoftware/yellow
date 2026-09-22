<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpeakerCategoryRequest;
use App\Models\SpeakerCategory;
use Illuminate\Http\RedirectResponse;

class SpeakerCategoryController extends Controller
{
    public function index()
    {
        $speakerCategories = SpeakerCategory::withCount('speakers')->ordered()->get();

        return view('admin.speaker-categories.index', compact('speakerCategories'));
    }

    public function create()
    {
        $speakerCategory = new SpeakerCategory();

        return view('admin.speaker-categories.create', compact('speakerCategory'));
    }

    public function store(SpeakerCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_home_featured'] = $request->boolean('is_home_featured');

        SpeakerCategory::create($data);

        return redirect()->route('admin.speaker-categories.index')->with('status', 'Category added.');
    }

    public function edit(SpeakerCategory $speakerCategory)
    {
        return view('admin.speaker-categories.edit', compact('speakerCategory'));
    }

    public function update(SpeakerCategoryRequest $request, SpeakerCategory $speakerCategory): RedirectResponse
    {
        $data = $request->validated();
        $data['is_home_featured'] = $request->boolean('is_home_featured');

        $speakerCategory->update($data);

        return redirect()->route('admin.speaker-categories.index')->with('status', 'Category updated.');
    }

    public function destroy(SpeakerCategory $speakerCategory): RedirectResponse
    {
        $speakerCategory->delete();

        return redirect()->route('admin.speaker-categories.index')->with('status', 'Category deleted.');
    }
}
