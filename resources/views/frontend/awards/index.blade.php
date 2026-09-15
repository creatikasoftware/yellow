@extends('layouts.app')

@section('title', "Awards | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Awards">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Awards'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Recognizing Achievers<br>Across Every Field</x-slot:title>
        <x-slot:subtitle>Explore categories designed to celebrate excellence, innovation, leadership and impact.</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @foreach($awards as $award)
                    <div class="col-6 col-md-4 col-lg-3">
                        <x-award-card
                            :icon="$award->icon"
                            :label="$award->name"
                            :description="$award->short_description"
                            :url="route('awards.show', $award->slug)"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
