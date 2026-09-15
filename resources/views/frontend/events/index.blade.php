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
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-6 col-lg-4"><x-event-card :event="$event" /></div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
