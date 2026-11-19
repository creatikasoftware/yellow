@extends('layouts.app')

@section('title', $award->name . " | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Award Category">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Awards', 'url' => route('awards.index')],
                ['label' => $award->name],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $award->name }}</x-slot:title>
        <x-slot:subtitle>{{ $award->short_description }}</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    @if($award->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($award->image) }}" alt="{{ $award->name }}" style="width:100%;height:390px;object-fit:cover">
                    @else
                        <div class="image-placeholder" style="height:390px"></div>
                    @endif
                </div>
                <div class="col-lg-5">
                    <div class="section-kicker">Category Overview</div>
                    @if($award->long_description)
                        <div class="detail-copy mt-3">{!! $award->long_description !!}</div>
                    @endif
                    <a href="{{ route('registration') }}" class="btn btn-gold">Submit a Nomination &rarr;</a>
                </div>
            </div>
        </div>
    </section>

@endsection
