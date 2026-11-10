@extends('admin.layouts.app')

@section('title', 'Partner Applications')

@section('content')

    <x-admin.page-heading title="Partner Applications" />

    <form method="GET" class="d-flex gap-2 mb-3">
        <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Organisation</th>
                    <th>Tier</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td>{{ $application->full_name }}</td>
                        <td class="small text-muted">{{ $application->email }}</td>
                        <td class="small text-muted">{{ $application->organization ?: '—' }}</td>
                        <td class="small text-muted">{{ $application->tier ?: '—' }}</td>
                        <td><span class="badge bg-{{ $application->status === 'contacted' ? 'success' : ($application->status === 'rejected' ? 'danger' : ($application->status === 'reviewed' ? 'info' : 'warning')) }}">{{ ucfirst($application->status) }}</span></td>
                        <td class="small text-muted">{{ $application->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.partner-applications.show', $application) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <x-admin.delete-button :action="route('admin.partner-applications.destroy', $application)" confirm="Delete this application?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted text-center py-4">No partner applications yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $applications->links() }}</div>

@endsection
