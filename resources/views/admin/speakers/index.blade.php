@extends('admin.layouts.app')

@section('title', 'Speakers')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Speakers</h1>
        <div>
            <a href="{{ route('admin.speaker-categories.index') }}" class="btn btn-outline-secondary btn-sm">Manage Categories</a>
            <a href="{{ route('admin.speakers.create') }}" class="btn btn-dark btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Speaker</a>
        </div>
    </div>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Category</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($speakers as $speaker)
                    <tr>
                        <td>{{ $speaker->name }}</td>
                        <td class="small text-muted">{{ $speaker->role }}</td>
                        <td class="small text-muted">{{ $speaker->category->name ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.speakers.destroy', $speaker)" confirm="Delete this speaker?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center py-4">No speakers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $speakers->links() }}</div>

@endsection
