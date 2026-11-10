@extends('admin.layouts.app')

@section('title', 'Partner Application Details')

@section('content')

    <x-admin.page-heading title="Partner Application: {{ $partnerApplication->full_name }}" />

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $partnerApplication->full_name }}</dd>
                        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $partnerApplication->email }}</dd>
                        <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $partnerApplication->phone }}</dd>
                        <dt class="col-sm-3">Organisation</dt><dd class="col-sm-9">{{ $partnerApplication->organization ?: '—' }}</dd>
                        <dt class="col-sm-3">City / Country</dt><dd class="col-sm-9">{{ $partnerApplication->city_country ?: '—' }}</dd>
                        <dt class="col-sm-3">Tier of Interest</dt><dd class="col-sm-9">{{ $partnerApplication->tier ?: '—' }}</dd>
                        <dt class="col-sm-3">Business / Network</dt><dd class="col-sm-9">{{ $partnerApplication->business_description ?: '—' }}</dd>
                        <dt class="col-sm-3">Submitted</dt><dd class="col-sm-9">{{ $partnerApplication->created_at->format('d M Y, h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.partner-applications.update', $partnerApplication) }}">
                        @csrf
                        @method('PUT')
                        <x-admin.select name="status" label="Status" :value="$partnerApplication->status" :options="['new' => 'New', 'reviewed' => 'Reviewed', 'contacted' => 'Contacted', 'rejected' => 'Rejected']" required />
                        <button type="submit" class="btn btn-dark w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
