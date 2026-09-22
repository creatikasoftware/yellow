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

    <section class="section">
        <div class="container">
            <div class="section-kicker">Upcoming</div>
            <h2 class="section-title mb-4">Upcoming Events</h2>

            @if($upcomingEvents->isEmpty())
                <p class="text-muted">No upcoming events scheduled right now — please check back soon.</p>
            @else
                <div class="row g-4">
                    @foreach($upcomingEvents as $event)
                        <div class="col-md-6 col-lg-4"><x-event-card :event="$event" /></div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if($pastEvents->isNotEmpty())
        <section class="section section-alt">
            <div class="container">
                <div class="section-kicker">Completed</div>
                <h2 class="section-title mb-4">Past Events</h2>

                <div class="row g-4">
                    @foreach($pastEvents as $event)
                        <div class="col-md-6 col-lg-4"><x-event-card :event="$event" past /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
