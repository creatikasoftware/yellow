@extends('admin.layouts.app')

@section('title', 'Speakers')

@section('content')

    <x-admin.page-heading title="Speakers" ctaText="Add Speaker" :ctaUrl="route('admin.speakers.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($speakers as $speaker)
                    <tr>
                        <td>{{ $speaker->name }}</td>
                        <td class="small text-muted">{{ $speaker->role }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.speakers.destroy', $speaker)" confirm="Delete this speaker?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center py-4">No speakers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $speakers->links() }}</div>

@endsection
