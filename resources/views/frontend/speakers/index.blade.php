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

    @php
        $uncategorized = $speakersByCategory->get(null, collect());
        $visibleCategories = $categories->filter(fn ($category) => $speakersByCategory->get($category->id, collect())->isNotEmpty());
        $hasTabs = $visibleCategories->isNotEmpty() && ($visibleCategories->count() > 1 || $uncategorized->isNotEmpty());
    @endphp

    <section class="section">
        <div class="container">
            @if($hasTabs)
                <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" role="tablist">
                    <button class="btn btn-sm btn-dark active" data-bs-toggle="pill" data-bs-target="#speakers-all" type="button">All</button>
                    @foreach($visibleCategories as $category)
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="pill" data-bs-target="#speakers-cat-{{ $category->id }}" type="button">{{ $category->name }}</button>
                    @endforeach
                    @if($uncategorized->isNotEmpty())
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="pill" data-bs-target="#speakers-other" type="button">Other</button>
                    @endif
                </div>
            @endif

            <div class="tab-content">
                <div class="tab-pane fade show active" id="speakers-all">
                    <div class="row g-4">
                        @foreach($categories as $category)
                            @foreach($speakersByCategory->get($category->id, collect()) as $speaker)
                                <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" /></div>
                            @endforeach
                        @endforeach
                        @foreach($uncategorized as $speaker)
                            <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" /></div>
                        @endforeach
                    </div>
                </div>

                @foreach($visibleCategories as $category)
                    <div class="tab-pane fade" id="speakers-cat-{{ $category->id }}">
                        <div class="row g-4">
                            @foreach($speakersByCategory->get($category->id) as $speaker)
                                <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" /></div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if($uncategorized->isNotEmpty())
                    <div class="tab-pane fade" id="speakers-other">
                        <div class="row g-4">
                            @foreach($uncategorized as $speaker)
                                <div class="col-6 col-lg-3"><x-speaker-card :speaker="$speaker" /></div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection
