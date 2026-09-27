@extends('admin.layouts.app')

@section('title', 'Hero Slides')

@section('content')

    <x-admin.page-heading title="Hero Slides" ctaText="Add Slide" :ctaUrl="route('admin.hero-slides.create')" />

    <p class="text-muted small">Shown as a slider on the homepage. Add multiple slides to enable the carousel — with only one slide, it displays as a single static hero. Each slide needs a background image; the title, subtitle and button are optional — leave them all blank to show just the image.</p>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Preview</th>
                    <th>Title</th>
                    <th>Sort Order</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($heroSlides as $slide)
                    <tr>
                        <td>
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($slide->image) }}" style="width:100px;height:56px;object-fit:cover;border-radius:4px">
                        </td>
                        <td class="small text-muted">{{ $slide->title ?: 'Image only, no text' }}</td>
                        <td>{{ $slide->sort_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.hero-slides.destroy', $slide)" confirm="Delete this hero slide?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center py-4">No hero slides yet — the homepage will show its default hero text until you add one.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
