@extends('admin.layouts.app')

@section('title', 'Registration Details')

@section('content')

    <x-admin.page-heading title="Registration: {{ $registration->full_name }}" />

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if($registration->photo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($registration->photo) }}" alt="{{ $registration->full_name }}" class="rounded mb-3" style="width:120px;height:120px;object-fit:cover">
                    @endif
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $registration->full_name }}</dd>
                        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $registration->email }}</dd>
                        <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $registration->phone }}</dd>
                        <dt class="col-sm-3">Organization</dt><dd class="col-sm-9">{{ $registration->organization ?: '—' }}</dd>
                        <dt class="col-sm-3">Industry</dt><dd class="col-sm-9">{{ $registration->industry ?: '—' }}</dd>
                        <dt class="col-sm-3">Registration Type</dt><dd class="col-sm-9">{{ $registration->registration_type ?: '—' }}</dd>
                        <dt class="col-sm-3">Event</dt><dd class="col-sm-9">{{ $registration->event->title ?? 'General' }}</dd>
                        <dt class="col-sm-3">Message</dt><dd class="col-sm-9">{{ $registration->message ?: '—' }}</dd>
                        <dt class="col-sm-3">Source</dt><dd class="col-sm-9">{{ $registration->source }}</dd>
                        <dt class="col-sm-3">Submitted</dt><dd class="col-sm-9">{{ $registration->created_at->format('d M Y, h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.registrations.update', $registration) }}">
                        @csrf
                        @method('PUT')
                        <x-admin.select name="status" label="Status" :value="$registration->status" :options="['pending' => 'Pending', 'confirmed' => 'Confirmed', 'rejected' => 'Rejected']" required />
                        <button type="submit" class="btn btn-dark w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
