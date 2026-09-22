@extends('admin.layouts.app')

@section('title', 'Gallery')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Gallery</h1>
        <div>
            <a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-outline-secondary btn-sm">Manage Categories</a>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-dark btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Image</a>
        </div>
    </div>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Preview</th>
                    <th>Caption</th>
                    <th>Event</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleryItems as $item)
                    <tr>
                        <td>
                            @if($item->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}" style="width:60px;height:44px;object-fit:cover;border-radius:4px">
                            @else
                                <span class="text-muted small">No image</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $item->caption }}</td>
                        <td class="small text-muted">{{ $item->event->title ?? '—' }}</td>
                        <td class="small text-muted">{{ $item->category->name ?? '—' }}</td>
                        <td>{{ $item->is_featured ? 'Yes' : '' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.gallery.destroy', $item)" confirm="Delete this gallery item?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted text-center py-4">No gallery items yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $galleryItems->links() }}</div>

@endsection
