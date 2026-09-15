@extends('layouts.app')

@section('title', "Speakers | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Our Speakers">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Speakers'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Voices That<br>Inspire Action</x-slot:title>
        <x-slot:subtitle>Meet leaders, entrepreneurs, experts and changemakers who share ideas that move industries forward.</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                @foreach($speakers as $speaker)
                    <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" /></div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
