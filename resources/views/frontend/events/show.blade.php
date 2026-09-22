@extends('layouts.app')

@section('title', $event->title . " | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Event Details">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Events', 'url' => route('events.index')],
                ['label' => $event->title],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $event->title }}</x-slot:title>
        <x-slot:subtitle>{{ $event->starts_at->format('d F Y') }} &middot; {{ $event->location }}</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($event->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}" alt="{{ $event->title }}" style="width:100%;height:430px;object-fit:cover">
                    @else
                        <div class="image-placeholder" style="height:430px"></div>
                    @endif

                    @if($event->description)
                        <div class="section-kicker mt-5">About The Event</div>
                        <h2 class="section-title">A Night Celebrating Extraordinary Achievement</h2>
                        <p class="detail-copy mt-3">{{ $event->description }}</p>
                    @endif

                    @if(!empty($event->highlights))
                        <h3 class="mt-5">Event Highlights</h3>
                        <ul class="detail-copy">
                            @foreach($event->highlights as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="info-box">
                        <h3>Event Information</h3>
                        <hr>
                        <p><strong>Date</strong><br>{{ $event->starts_at->format('d F Y') }}</p>
                        <p><strong>Venue</strong><br>{{ $event->location }}</p>
                        @if($event->format)
                            <p><strong>Format</strong><br>{{ $event->format }}</p>
                        @endif
                        <a href="{{ route('registration') }}" class="btn btn-gold w-100">Register for Event</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($event->agendaItems->isNotEmpty())
        <section class="section section-alt">
            <div class="container">
                <div class="section-kicker">Event Agenda</div>
                <h2 class="section-title mb-4">Program at a Glance</h2>
                <div class="timeline">
                    @foreach($event->agendaItems as $item)
                        <div class="timeline-item">
                            <strong>{{ $item->time }}</strong>
                            <h4>{{ $item->title }}</h4>
                            @if($item->description)
                                <p class="small-muted">{{ $item->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
