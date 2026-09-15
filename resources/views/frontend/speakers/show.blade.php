@extends('layouts.app')

@section('title', $speaker->name . " | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Speaker Profile">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Speakers', 'url' => route('speakers.index')],
                ['label' => $speaker->name],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $speaker->name }}</x-slot:title>
        <x-slot:subtitle>{{ $speaker->tagline ?? $speaker->role }}</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-4">
                    <div class="speaker-image" style="height:390px"></div>
                </div>
                <div class="col-lg-8">
                    @if($speaker->bio)
                        <div class="section-kicker">About The Speaker</div>
                        <h2 class="section-title">Leadership With Purpose</h2>
                        <p class="detail-copy mt-3">{{ $speaker->bio }}</p>
                    @endif

                    @if(!empty($speaker->expertise))
                        <h3 class="mt-4">Areas of Expertise</h3>
                        <div class="row g-3 mt-2">
                            @foreach($speaker->expertise as $skill)
                                <div class="col-md-4"><div class="info-box">{{ $skill }}</div></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
