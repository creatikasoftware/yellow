@extends('layouts.app')

@section('title', $content['title'] . " | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Legal">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => $content['title']],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $content['title'] }}</x-slot:title>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="detail-copy">{!! $content['body'] !!}</div>
                </div>
            </div>
        </div>
    </section>

@endsection
