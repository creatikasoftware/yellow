@extends('layouts.app')

@section('title', "Home | Yellow Achiever's Award")

@section('content')

    @if($heroSlides->isNotEmpty())
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            @if($heroSlides->count() > 1)
                <div class="carousel-indicators">
                    @foreach($heroSlides as $i => $slide)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" @if($i === 0) aria-current="true" @endif aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif

            <div class="carousel-inner">
                @foreach($heroSlides as $i => $slide)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <header class="page-hero" style="min-height:560px;display:flex;align-items:center;background-image:linear-gradient(115deg, rgba(7,9,12,.85), rgba(22,27,32,.75) 58%, rgba(43,33,17,.6)), url('{{ \Illuminate\Support\Facades\Storage::url($slide->image) }}');background-size:cover;background-position:center">
                            <div class="container">
                                @if($slide->title)
                                    @if($slide->eyebrow)
                                        <div class="eyebrow">{{ $slide->eyebrow }}</div>
                                    @endif
                                    <h1>{{ $slide->title }}</h1>
                                    @if($slide->subtitle)
                                        <p>{{ $slide->subtitle }}</p>
                                    @endif
                                    @if($slide->button_text && $slide->button_url)
                                        <div class="mt-4">
                                            <a class="btn btn-gold" href="{{ $slide->button_url }}">{{ $slide->button_text }} &rarr;</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </header>
                    </div>
                @endforeach
            </div>

            @if($heroSlides->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    @else
        <x-page-header :eyebrow="$content['hero_eyebrow']" style="min-height:560px;display:flex;align-items:center">
            <x-slot:title>{{ $content['hero_title_line1'] }} <span style="color:#d5a43b">{{ $content['hero_title_highlight'] }}</span><br>{{ $content['hero_title_line2'] }}</x-slot:title>
            <x-slot:subtitle>{{ $content['hero_subtitle'] }}</x-slot:subtitle>
            <div class="mt-4">
                <a class="btn btn-gold me-2" href="{{ route('registration') }}">{{ $content['hero_cta_primary'] }} &rarr;</a>
                <a class="btn btn-outline-light" href="{{ route('events.index') }}">{{ $content['hero_cta_secondary'] }}</a>
            </div>
        </x-page-header>
    @endif

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
        <x-featured-event-widget :event="$featuredEvent" :content="$content" />
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
