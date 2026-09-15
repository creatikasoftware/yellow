@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')

    <x-admin.page-heading title="Contact Messages" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>{{ $message->name }}</td>
                        <td class="small text-muted">{{ $message->subject ?: 'General Enquiry' }}</td>
                        <td class="small text-muted">{{ $message->created_at->format('d M Y') }}</td>
                        <td>
                            @if($message->status === 'unread')
                                <span class="badge bg-primary">Unread</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($message->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <x-admin.delete-button :action="route('admin.contact-messages.destroy', $message)" confirm="Delete this message?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $messages->links() }}</div>

@endsection
