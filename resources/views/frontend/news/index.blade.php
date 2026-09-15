@extends('layouts.app')

@section('title', "News | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Latest News">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'News'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Updates &amp;<br>Announcements</x-slot:title>
        <x-slot:subtitle>Stories, announcements, award updates and highlights from Yellow Achiever's Award.</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                @foreach($articles as $article)
                    <div class="col-md-6 col-lg-4">
                        <div class="card-clean">
                            <div class="image-placeholder news-image"></div>
                            <div class="card-body-custom">
                                <div class="meta">{{ $article->published_at->format('d M Y') }}</div>
                                <h3 class="card-title">{{ $article->title }}</h3>
                                <p class="small-muted">{{ $article->excerpt }}</p>
                                <a class="arrow-link" href="{{ route('news.show', $article->slug) }}">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
