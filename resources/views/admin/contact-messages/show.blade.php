@extends('admin.layouts.app')

@section('title', 'Message Details')

@section('content')

    <x-admin.page-heading title="Message from {{ $contactMessage->name }}" />

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-2">Name</dt><dd class="col-sm-10">{{ $contactMessage->name }}</dd>
                <dt class="col-sm-2">Email</dt><dd class="col-sm-10">{{ $contactMessage->email }}</dd>
                <dt class="col-sm-2">Phone</dt><dd class="col-sm-10">{{ $contactMessage->phone ?: '—' }}</dd>
                <dt class="col-sm-2">Subject</dt><dd class="col-sm-10">{{ $contactMessage->subject ?: 'General Enquiry' }}</dd>
                <dt class="col-sm-2">Received</dt><dd class="col-sm-10">{{ $contactMessage->created_at->format('d M Y, h:i A') }}</dd>
                <dt class="col-sm-2">Message</dt><dd class="col-sm-10" style="white-space:pre-line">{{ $contactMessage->message }}</dd>
            </dl>
        </div>
    </div>

    <a href="mailto:{{ $contactMessage->email }}" class="btn btn-dark mt-3">Reply by Email</a>

@endsection
