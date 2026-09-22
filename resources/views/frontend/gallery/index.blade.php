@extends('layouts.app')

@section('title', "Gallery | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Event Gallery">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Gallery'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Moments Worth<br>Remembering</x-slot:title>
        <x-slot:subtitle>Browse highlights from award ceremonies, summits, conversations and networking events.</x-slot:subtitle>
    </x-page-header>

    @if($categories->isNotEmpty())
        <section class="section pb-0">
            <div class="container">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('gallery.index') }}" class="btn btn-sm {{ $activeCategory ? 'btn-outline-dark' : 'btn-dark' }}">All</a>
                    @foreach($categories as $category)
                        <a href="{{ route('gallery.index', ['category' => $category->slug]) }}" class="btn btn-sm {{ $activeCategory && $activeCategory->is($category) ? 'btn-dark' : 'btn-outline-dark' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(!$featuredItem && $otherItems->isEmpty())
        <section class="section">
            <div class="container">
                <p class="text-muted text-center py-5">
                    @if($activeCategory)
                        No gallery photos in "{{ $activeCategory->name }}" yet — try another category.
                    @else
                        No gallery photos are available right now — please check back soon.
                    @endif
                </p>
            </div>
        </section>
    @elseif($featuredItem)
        <section class="section">
            <div class="container">
                <div class="row g-3">
                    <div class="col-lg-6"><x-gallery-card :item="$featuredItem" large /></div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            @foreach($otherItems->take(4) as $item)
                                <div class="col-6"><x-gallery-card :item="$item" /></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($otherItems->count() > 4)
            <section class="section section-alt">
                <div class="container">
                    <div class="row g-3">
                        @foreach($otherItems->skip(4)->take(6) as $item)
                            <div class="col-6 col-md-4"><x-gallery-card :item="$item" /></div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @else
        <section class="section">
            <div class="container">
                <div class="row g-3">
                    @foreach($otherItems->take(10) as $item)
                        <div class="col-6 col-md-4 col-lg-3"><x-gallery-card :item="$item" /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
