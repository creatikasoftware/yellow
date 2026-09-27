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

    @if($ourAwards->isNotEmpty())
        <section class="section">
            <div class="container">
                <div class="section-kicker">Our Awards</div>
                <h2 class="section-title mb-4">Our Awards</h2>
                <div class="row g-3">
                    @foreach($ourAwards as $award)
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
    @endif

    <section class="section {{ $ourAwards->isNotEmpty() ? 'section-alt' : '' }}">
        <div class="container">
            <div class="section-kicker">Our Categories</div>
            <h2 class="section-title mb-4">Our Categories</h2>
            <div class="row g-3">
                @foreach($ourCategories as $award)
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
