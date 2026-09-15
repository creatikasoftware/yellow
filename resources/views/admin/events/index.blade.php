@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')

    <x-admin.page-heading title="Events" ctaText="Add Event" :ctaUrl="route('admin.events.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->starts_at->format('d M Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td><span class="badge bg-{{ $event->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($event->status) }}</span></td>
                        <td>{{ $event->is_featured ? 'Yes' : '' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.events.destroy', $event)" confirm="Delete this event?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted text-center py-4">No events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $events->links() }}</div>

@endsection
