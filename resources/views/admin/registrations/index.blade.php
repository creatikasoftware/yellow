@extends('admin.layouts.app')

@section('title', 'Registrations')

@section('content')

    <x-admin.page-heading title="Registrations" />

    <form method="GET" class="d-flex gap-2 mb-3">
        <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td>{{ $registration->full_name }}</td>
                        <td class="small text-muted">{{ $registration->email }}</td>
                        <td class="small text-muted">{{ $registration->event->title ?? 'General' }}</td>
                        <td class="small text-muted">{{ $registration->registration_type }}</td>
                        <td><span class="badge bg-{{ $registration->status === 'confirmed' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($registration->status) }}</span></td>
                        <td class="small text-muted">{{ $registration->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <x-admin.delete-button :action="route('admin.registrations.destroy', $registration)" confirm="Delete this registration?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted text-center py-4">No registrations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $registrations->links() }}</div>

@endsection
