@extends('layouts.app')

@section('title', "Contact | Yellow Achiever's Award")

@section('content')

    <x-page-header :eyebrow="$content['hero_eyebrow']">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Contact'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $content['hero_title_line1'] }}<br>{{ $content['hero_title_line2'] }}</x-slot:title>
        <x-slot:subtitle>{{ $content['hero_subtitle'] }}</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="section-kicker">{{ $content['intro_kicker'] }}</div>
                    <h2 class="section-title">{{ $content['intro_title'] }}</h2>
                    <div class="info-box mt-4">
                        <p><i class="bi bi-geo-alt text-warning me-2"></i><strong>Address</strong><br><span class="small-muted">{{ $site['contact_address'] }}</span></p>
                        <p><i class="bi bi-telephone text-warning me-2"></i><strong>Phone</strong><br><span class="small-muted">{{ $site['contact_phone'] }}</span></p>
                        <p class="mb-0"><i class="bi bi-envelope text-warning me-2"></i><strong>Email</strong><br><span class="small-muted">{{ $site['contact_email'] }}</span></p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-clean p-4">
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Your name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+91">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select" name="subject">
                                        <option>General Enquiry</option>
                                        <option>Nomination</option>
                                        <option>Sponsorship</option>
                                        <option>Partnership</option>
                                        <option>Speaking</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="6" placeholder="How can we help?">{{ old('message') }}</textarea>
                                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-gold">Send Enquiry &rarr;</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
