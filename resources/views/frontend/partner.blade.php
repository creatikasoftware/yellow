@extends('layouts.app')

@section('title', "Partner With Us | Yellow Achiever's Award")

@section('content')

    <header class="page-hero">
        <div class="container">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Partner With Us'],
            ]" />

            <div class="row g-5 align-items-start mt-2">
                <div class="col-lg-7">
                    <div class="eyebrow mb-3">{{ $content['hero_eyebrow'] }}</div>
                    <h1 class="mb-3">{{ $content['hero_title'] }}</h1>
                    <p class="mb-4">{{ $content['hero_subtitle'] }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="#partner-application-form" class="btn btn-gold">{{ $content['hero_cta_primary'] }} &rarr;</a>
                        <a href="#partnership-tiers" class="btn btn-outline-light">{{ $content['hero_cta_secondary'] }}</a>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        @foreach($content['tags'] as $i => $tag)
                            <span class="partner-tag{{ $i === 0 ? ' is-accent' : '' }}">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row g-3">
                        @foreach($content['stats'] as $stat)
                            <div class="col-6">
                                <div class="partner-stat-card">
                                    <strong>{{ $stat['value'] }}</strong>
                                    <span>{{ $stat['label'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="partner-testimonial-card mt-3">
                        <div class="eyebrow mb-2">{{ $content['testimonial_kicker'] }}</div>
                        <p class="mb-2">&ldquo;{{ $content['testimonial_quote'] }}&rdquo;</p>
                        <cite>&mdash; {{ $content['testimonial_author'] }}</cite>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if(!empty($content['tiers']))
        <section class="section" id="partnership-tiers">
            <div class="container">
                <div class="section-kicker">Partnership Tiers</div>
                <h2 class="section-title mb-4">Choose the Tier That Fits You</h2>
                <div class="row g-3">
                    @foreach($content['tiers'] as $tier)
                        <div class="col-md-4">
                            <div class="info-box h-100">
                                <h3 class="mb-0">{{ $tier }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section section-alt" id="partner-application-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card-clean p-4 p-lg-5">
                        <h2 class="section-title mb-1">{{ $content['form_title'] }}</h2>
                        <p class="small-muted mb-4">{{ $content['form_subtitle'] }}</p>

                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('partner.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" placeholder="Your full name">
                                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Organisation / Business Name</label>
                                    <input class="form-control" name="organization" value="{{ old('organization') }}" placeholder="Your company or firm name">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">&#127470;&#127475; +91</span>
                                        <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="98765 43210">
                                    </div>
                                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="you@company.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">City / Country</label>
                                    <input class="form-control" name="city_country" value="{{ old('city_country') }}" placeholder="e.g. Mumbai, India">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Partnership Tier of Interest</label>
                                    <select class="form-select" name="tier">
                                        <option value="" selected disabled>Select tier</option>
                                        @foreach($content['tiers'] as $tier)
                                            <option value="{{ $tier }}" {{ old('tier') === $tier ? 'selected' : '' }}>{{ $tier }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Your Current Business / Network (Brief Description)</label>
                                    <textarea class="form-control" name="business_description" rows="4" placeholder="e.g. I run an events consultancy in Pune with 200+ corporate contacts per year...">{{ old('business_description') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-gold w-100">Submit Partner Application &rarr;</button>
                                </div>

                                <div class="col-12 text-center">
                                    <small class="small-muted"><i class="bi bi-lock-fill me-1"></i>Your information is confidential. Response within 48 business hours.</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
