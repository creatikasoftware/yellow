@extends('layouts.app')

@section('title', "Events | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Our Events">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Events'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Events That Connect<br>Achievers &amp; Leaders</x-slot:title>
        <x-slot:subtitle>Explore upcoming summits, award ceremonies, forums and networking experiences.</x-slot:subtitle>
    </x-page-header>

    @php
        $hasTabs = $upcomingEvents->isNotEmpty() && $pastEvents->isNotEmpty();
    @endphp

    <section class="section">
        <div class="container">
            @if($hasTabs)
                <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" role="tablist">
                    <button class="btn btn-sm btn-dark active" data-bs-toggle="pill" data-bs-target="#events-all" type="button">All Events</button>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="pill" data-bs-target="#events-upcoming" type="button">Upcoming</button>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="pill" data-bs-target="#events-past" type="button">Past Events</button>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="events-all">
                        <div class="row g-4">
                            @foreach($upcomingEvents as $event)
                                <div class="col-md-6 col-lg-4"><x-event-card :event="$event" /></div>
                            @endforeach
                            @foreach($pastEvents as $event)
                                <div class="col-md-6 col-lg-4"><x-event-card :event="$event" past /></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="events-upcoming">
                        <div class="row g-4">
                            @foreach($upcomingEvents as $event)
                                <div class="col-md-6 col-lg-4"><x-event-card :event="$event" /></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="events-past">
                        <div class="row g-4">
                            @foreach($pastEvents as $event)
                                <div class="col-md-6 col-lg-4"><x-event-card :event="$event" past /></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($upcomingEvents->isNotEmpty())
                <div class="row g-4">
                    @foreach($upcomingEvents as $event)
                        <div class="col-md-6 col-lg-4"><x-event-card :event="$event" /></div>
                    @endforeach
                </div>
            @elseif($pastEvents->isNotEmpty())
                <div class="row g-4">
                    @foreach($pastEvents as $event)
                        <div class="col-md-6 col-lg-4"><x-event-card :event="$event" past /></div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No events to show right now — please check back soon.</p>
            @endif
        </div>
    </section>

    @if($featuredEvent)
        <x-featured-event-widget :event="$featuredEvent" :content="$content" />
    @endif

@endsection
