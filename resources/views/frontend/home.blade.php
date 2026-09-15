@extends('layouts.app')

@section('title', "Home | Yellow Achiever's Award")

@section('content')

    <x-page-header :eyebrow="$content['hero_eyebrow']" style="min-height:560px;display:flex;align-items:center">
        <x-slot:title>{{ $content['hero_title_line1'] }} <span style="color:#d5a43b">{{ $content['hero_title_highlight'] }}</span><br>{{ $content['hero_title_line2'] }}</x-slot:title>
        <x-slot:subtitle>{{ $content['hero_subtitle'] }}</x-slot:subtitle>
        <div class="mt-4">
            <a class="btn btn-gold me-2" href="{{ route('registration') }}">{{ $content['hero_cta_primary'] }} &rarr;</a>
            <a class="btn btn-outline-light" href="{{ route('events.index') }}">{{ $content['hero_cta_secondary'] }}</a>
        </div>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <div class="section-kicker">{{ $content['about_kicker'] }}</div>
                    <h2 class="section-title">{{ $content['about_title'] }}</h2>
                    <p class="detail-copy mt-3">{{ $content['about_body'] }}</p>
                    <a href="{{ route('about') }}" class="btn btn-gold">{{ $content['about_cta_text'] }} &rarr;</a>
                </div>
                <div class="col-lg-4">
                    <div class="info-box">
                        @php($icons = ['bi-trophy', 'bi-people', 'bi-bar-chart', 'bi-heart'])
                        @foreach($content['info_box_items'] as $index => $item)
                            <p class="{{ $loop->last ? 'mb-0' : '' }}"><i class="bi {{ $icons[$index] ?? 'bi-star' }} text-warning me-2"></i><strong>{{ $item }}</strong></p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats py-4" style="background:#0b1118;color:#fff">
        <div class="container">
            <div class="row text-center">
                @foreach($homeStats as $stat)
                    <div class="col-6 col-lg-3 p-3">
                        <b style="font-size:32px;color:#d5a43b">{{ $stat['value'] }}</b>
                        <div>{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <x-section-heading :kicker="$content['events_kicker']" :title="$content['events_title']" ctaText="View All Events" :ctaUrl="route('events.index')" />
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4"><x-event-card :event="$event" compact /></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-section-heading :kicker="$content['awards_kicker']" :title="$content['awards_title']" ctaText="View All Categories" :ctaUrl="route('awards.index')" />
            <div class="row g-3">
                @foreach($awards as $award)
                    <div class="col-6 col-md-4 col-lg-2">
                        <x-award-card :icon="$award->icon" :label="$award->name" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <x-section-heading :kicker="$content['speakers_kicker']" :title="$content['speakers_title']" ctaText="View All Speakers" :ctaUrl="route('speakers.index')" />
            <div class="row g-4">
                @foreach($speakers as $speaker)
                    <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" :with-link="false" /></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-section-heading :kicker="$content['gallery_kicker']" :title="$content['gallery_title']" ctaText="View Full Gallery" :ctaUrl="route('gallery.index')" />
            <div class="row g-3">
                @if($featuredGalleryItem)
                    <div class="col-lg-6"><x-gallery-card :item="$featuredGalleryItem" large /></div>
                @endif
                <div class="col-lg-6">
                    <div class="row g-3">
                        @foreach($otherGalleryItems->take(4) as $item)
                            <div class="col-6"><x-gallery-card :item="$item" /></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================
         UPCOMING EVENT / REGISTRATION
    ================================= --}}
    @if($featuredEvent)
    <section class="ya-event-registration">
        <div class="container">

            <div class="ya-event-heading text-center">
                <div class="ya-event-eyebrow"><span></span> {{ $content['registration_eyebrow'] }} <span></span></div>
                <h2>{{ $content['registration_title_line1'] }} <em>{{ $content['registration_title_highlight'] }}</em></h2>
                <p>{{ $content['registration_subtitle'] }}</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="row g-4 g-xl-5 align-items-stretch">

                <div class="col-lg-6">
                    <div class="ya-event-card">
                        <div class="ya-event-overlay"></div>
                        <div class="ya-event-content">
                            @if($featuredEvent->registration_open)
                                <div class="ya-registration-badge">REGISTRATIONS OPEN</div>
                            @endif

                            <h3>YELLOW ACHIEVER'S <strong>LEADERSHIP SUMMIT 2026</strong></h3>

                            <div class="ya-event-details">
                                <div class="ya-event-detail">
                                    <div class="ya-event-icon"><i class="bi bi-calendar3"></i></div>
                                    <div><strong>{{ $featuredEvent->starts_at->format('l, d F Y') }}</strong></div>
                                </div>

                                @if($featuredEvent->start_time)
                                    <div class="ya-event-detail">
                                        <div class="ya-event-icon"><i class="bi bi-clock"></i></div>
                                        <div><strong>{{ $featuredEvent->start_time }} &ndash; {{ $featuredEvent->end_time }}</strong></div>
                                    </div>
                                @endif

                                <div class="ya-event-detail">
                                    <div class="ya-event-icon"><i class="bi bi-geo-alt"></i></div>
                                    <div><strong>{{ $featuredEvent->location }}</strong></div>
                                </div>

                                @if($featuredEvent->expected_attendees)
                                    <div class="ya-event-detail">
                                        <div class="ya-event-icon"><i class="bi bi-people"></i></div>
                                        <div><strong>{{ $featuredEvent->expected_attendees }}</strong></div>
                                    </div>
                                @endif
                            </div>

                            <div class="ya-event-actions">
                                <a href="#" class="ya-btn ya-btn-gold"><i class="bi bi-download"></i> Download Brochure</a>
                                <a href="{{ route('events.show', $featuredEvent->slug) }}" class="ya-btn ya-btn-outline"><i class="bi bi-arrow-right"></i> Event Details</a>
                            </div>

                            <div class="ya-countdown">
                                <div class="ya-countdown-title"><i class="bi bi-hourglass-split"></i> Event Starts In</div>
                                <div class="ya-countdown-items">
                                    <div class="ya-countdown-item"><strong>45</strong><span>DAYS</span></div>
                                    <div class="ya-countdown-item"><strong>12</strong><span>HOURS</span></div>
                                    <div class="ya-countdown-item"><strong>30</strong><span>MINS</span></div>
                                    <div class="ya-countdown-item"><strong>20</strong><span>SECS</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ya-registration-card">
                        <div class="ya-form-heading">
                            <div class="ya-form-line"></div>
                            <h3>Reserve Your Seat</h3>
                            <p>Fill in your details. Our team will confirm your registration within 24 hours.</p>
                        </div>

                        <form method="POST" action="{{ route('registration.store') }}">
                            @csrf
                            <input type="hidden" name="event_slug" value="{{ $featuredEvent->slug }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="ya-form-label">First Name <span>*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control ya-form-control @error('first_name') is-invalid @enderror" placeholder="Rahul">
                                    @error('first_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="ya-form-label">Last Name <span>*</span></label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control ya-form-control @error('last_name') is-invalid @enderror" placeholder="Sharma">
                                    @error('last_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="ya-form-label">Email Address <span>*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control ya-form-control @error('email') is-invalid @enderror" placeholder="rahul@company.com">
                                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="ya-form-label">Phone Number <span>*</span></label>
                                    <div class="ya-phone-input">
                                        <span class="ya-country-code">&#127470;&#127475;</span>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control ya-form-control @error('phone') is-invalid @enderror" placeholder="+91 98765 43210">
                                    </div>
                                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="ya-form-label">Company</label>
                                    <input type="text" name="organization" value="{{ old('organization') }}" class="form-control ya-form-control" placeholder="Acme Corp">
                                </div>

                                <div class="col-md-6">
                                    <label class="ya-form-label">Industry</label>
                                    <select name="industry" class="form-select ya-form-control">
                                        <option selected disabled value="">Select Industry</option>
                                        <option>Technology</option>
                                        <option>Finance</option>
                                        <option>Healthcare</option>
                                        <option>Education</option>
                                        <option>Manufacturing</option>
                                        <option>Retail</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="ya-form-label">Registration Type</label>
                                    <select name="registration_type" class="form-select ya-form-control">
                                        <option selected disabled value="">Select Type</option>
                                        <option>Delegate</option>
                                        <option>Speaker</option>
                                        <option>Sponsor</option>
                                        <option>Partner</option>
                                        <option>Nominee</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="ya-form-label">Message <small>(Optional)</small></label>
                                    <textarea name="message" class="form-control ya-form-control ya-textarea" rows="4" placeholder="Any specific requirements?">{{ old('message') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <div class="ya-terms">
                                        <input type="checkbox" id="yaTerms" name="agreed_terms" value="1">
                                        <label for="yaTerms">I agree to the <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a> <span>*</span></label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="ya-submit-btn">Confirm Registration <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="ya-secure"><i class="bi bi-lock-fill"></i> Your information is secure and confidential.</div>
                    </div>
                </div>
            </div>

            <div class="ya-event-benefits">
                <div class="ya-benefit">
                    <div class="ya-benefit-icon"><i class="bi bi-people"></i></div>
                    <div><strong>Network</strong><span>Connect with industry leaders</span></div>
                </div>
                <div class="ya-benefit">
                    <div class="ya-benefit-icon"><i class="bi bi-lightbulb"></i></div>
                    <div><strong>Learn</strong><span>Gain valuable insights</span></div>
                </div>
                <div class="ya-benefit">
                    <div class="ya-benefit-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div><strong>Grow</strong><span>Explore new opportunities</span></div>
                </div>
                <div class="ya-benefit">
                    <div class="ya-benefit-icon"><i class="bi bi-award"></i></div>
                    <div><strong>Be Recognized</strong><span>Celebrate achievements</span></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($featuredTestimonial)
    <section class="ya-testimonials">
        <div class="container">
            <div class="ya-testimonials-header">
                <div class="ya-heading-content">
                    <div class="ya-eyebrow"><span></span> {{ $content['testimonials_eyebrow'] }}</div>
                    <h2>{{ $content['testimonials_title_line1'] }} <em>{{ $content['testimonials_title_highlight'] }}</em></h2>
                </div>
                <p class="ya-heading-description">{{ $content['testimonials_subtitle'] }}</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <x-testimonial-card :testimonial="$featuredTestimonial" featured />
                </div>

                <div class="col-lg-5">
                    <div class="ya-testimonial-list">
                        @foreach($smallTestimonials as $testimonial)
                            <x-testimonial-card :testimonial="$testimonial" />
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="ya-trust-stats">
                @foreach($trustStats as $stat)
                    <div class="ya-stat">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="section py-5">
        <div class="container">
            <div class="section-kicker mb-4">{{ $content['partners_kicker'] }}</div>
            <div class="row align-items-center text-center g-4">
                @foreach($partners as $partner)
                    <x-partner-logo :partner="$partner" />
                @endforeach
            </div>
        </div>
    </section>

@endsection
