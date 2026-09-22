@extends('admin.layouts.app')

@section('title', 'Gallery Categories')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Gallery Categories</h1>
        <div>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary btn-sm">Back to Gallery</a>
            <a href="{{ route('admin.gallery-categories.create') }}" class="btn btn-dark btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Category</a>
        </div>
    </div>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Items</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleryCategories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="small text-muted">{{ $category->slug }}</td>
                        <td>{{ $category->gallery_items_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.gallery-categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.gallery-categories.destroy', $category)" confirm="Delete this category? Gallery items in it will become uncategorized." />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center py-4">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
