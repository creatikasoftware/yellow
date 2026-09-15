@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <x-admin.page-heading title="Dashboard" />

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['events'] }}</strong>Events</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['awards'] }}</strong>Award Categories</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['speakers'] }}</strong>Speakers</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['gallery_items'] }}</strong>Gallery Items</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['news_articles'] }}</strong>News Articles</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['partners'] }}</strong>Partners</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['testimonials'] }}</strong>Testimonials</div></div>
        <div class="col-6 col-lg-3"><div class="card-stat"><strong>{{ $stats['registrations'] }}</strong>Registrations ({{ $stats['pending_registrations'] }} pending)</div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Registrations</span>
                    <a href="{{ route('admin.registrations.index') }}" class="small">View all &rarr;</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentRegistrations as $registration)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $registration->full_name }}</strong>
                                <div class="small text-muted">{{ $registration->event->title ?? 'General' }} &middot; {{ $registration->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge bg-{{ $registration->status === 'confirmed' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($registration->status) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No registrations yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Contact Messages</span>
                    <a href="{{ route('admin.contact-messages.index') }}" class="small">View all &rarr;</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentMessages as $message)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $message->name }}</strong>
                                <div class="small text-muted">{{ $message->subject ?? 'General Enquiry' }} &middot; {{ $message->created_at->diffForHumans() }}</div>
                            </div>
                            @if($message->status === 'unread')
                                <span class="badge bg-primary">New</span>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No messages yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection
