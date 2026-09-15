@extends('layouts.app')

@section('title', $service->meta_title_or_fallback . " | Yellow Achiever's Award")
@section('canonical', route('services.show', $service))
@if($service->meta_description_or_fallback)
    @section('meta_description', $service->meta_description_or_fallback)
@endif
@if($service->meta_keywords)
    @section('meta_keywords', $service->meta_keywords)
@endif
@if($service->featured_image)
    @section('og_image', \Illuminate\Support\Facades\Storage::url($service->featured_image))
@endif

@section('content')

    <x-page-header eyebrow="Our Services">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services', 'url' => route('services.index')],
                ['label' => $service->title],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $service->title }}</x-slot:title>
        @if($service->short_description)
            <x-slot:subtitle>{{ $service->short_description }}</x-slot:subtitle>
        @endif
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($service->featured_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($service->featured_image) }}" alt="{{ $service->title }}" class="service-detail-image">
                    @else
                        <div class="image-placeholder" style="height:390px"></div>
                    @endif

                    @if($service->icon)
                        <div class="mt-4"><i class="bi {{ $service->icon }}" style="font-size:36px;color:var(--gold,#d5a43b)"></i></div>
                    @endif

                    <div class="section-kicker mt-3">About This Service</div>
                    <h2 class="section-title">{{ $service->title }}</h2>

                    @if($service->description)
                        @foreach(explode("\n\n", $service->description) as $paragraph)
                            <p class="detail-copy mt-3">{{ $paragraph }}</p>
                        @endforeach
                    @elseif($service->short_description)
                        <p class="detail-copy mt-3">{{ $service->short_description }}</p>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="info-box">
                        <h3>Interested in This Service?</h3>
                        <hr>
                        <p class="small-muted">Get in touch with our team to discuss how we can help bring your event to life.</p>
                        <a href="{{ route('contact') }}" class="btn btn-gold w-100">Enquire Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($relatedServices->isNotEmpty())
        <section class="section section-alt">
            <div class="container">
                <x-section-heading kicker="Explore More" title="Other Services" ctaText="View All Services" :ctaUrl="route('services.index')" />
                <div class="row g-4">
                    @foreach($relatedServices as $related)
                        <div class="col-md-6 col-lg-4">
                            <x-service-card :service="$related" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
