@extends('layouts.app')

@section('title', $article->title . " | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="News &amp; Updates">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'News', 'url' => route('news.index')],
                ['label' => $article->title],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $article->title }}</x-slot:title>
        <x-slot:subtitle>{{ $article->published_at->format('d F Y') }} &middot; Yellow Achiever's Award</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="image-placeholder" style="height:430px"></div>

                    @if($article->body)
                        @foreach(explode("\n\n", $article->body) as $index => $paragraph)
                            @if($index === 0)
                                <h2 class="section-title mt-5">Celebrating the People Behind Meaningful Achievement</h2>
                            @endif
                            <p class="detail-copy mt-3">{{ $paragraph }}</p>
                        @endforeach
                    @endif

                    <a href="{{ route('registration') }}" class="btn btn-gold mt-3">Submit a Nomination &rarr;</a>
                </div>
            </div>
        </div>
    </section>

@endsection
