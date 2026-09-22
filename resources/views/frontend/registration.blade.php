@extends('layouts.app')

@section('title', "Registration | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Registration">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Registration'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Join the Yellow<br>Achiever's Community</x-slot:title>
        <x-slot:subtitle>Register for an event, submit a nomination or express interest in partnership opportunities.</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card-clean p-4 p-lg-5">
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Profile Photo <small>(Optional)</small></label>
                                    <input type="file" name="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror">
                                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}">
                                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone *</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Organization</label>
                                    <input class="form-control" name="organization" value="{{ old('organization') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Registration Type</label>
                                    <select class="form-select" name="registration_type">
                                        <option>Event Registration</option>
                                        <option>Award Nomination</option>
                                        <option>Sponsorship</option>
                                        <option>Partnership</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Select Event</label>
                                    <select class="form-select" name="event_slug">
                                        @foreach($events as $event)
                                            <option value="{{ $event->slug }}">{{ $event->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="5">{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-gold">Submit Registration &rarr;</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
