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

    @if(!$featuredItem && $otherItems->isEmpty())
        <section class="section">
            <div class="container">
                <p class="text-muted text-center py-5">No gallery photos are available right now — please check back soon.</p>
            </div>
        </section>
    @else
        <section class="section">
            <div class="container">
                <div class="row g-3">
                    @if($featuredItem)
                        <div class="col-lg-6"><x-gallery-card :item="$featuredItem" large /></div>
                    @endif
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
    @endif

@endsection
