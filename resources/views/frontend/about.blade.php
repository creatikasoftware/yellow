@extends('layouts.app')

@section('title', "About Us | Yellow Achiever's Award")

@section('content')

    <x-page-header :eyebrow="$content['hero_eyebrow']">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'About'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>{{ $content['hero_title_line1'] }}<br>{{ $content['hero_title_line2'] }}</x-slot:title>
        <x-slot:subtitle>{{ $content['hero_subtitle'] }}</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="image-placeholder" style="height:430px"></div>
                </div>
                <div class="col-lg-6">
                    <div class="section-kicker">{{ $content['intro_kicker'] }}</div>
                    <h2 class="section-title">{{ $content['intro_title'] }}</h2>
                    <p class="detail-copy mt-3">{{ $content['intro_body_1'] }}</p>
                    <p class="detail-copy">{{ $content['intro_body_2'] }}</p>
                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="info-box">
                                <h3>{{ $content['stat_1_value'] }}</h3>
                                <p class="mb-0 small-muted">{{ $content['stat_1_label'] }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <h3>{{ $content['stat_2_value'] }}</h3>
                                <p class="mb-0 small-muted">{{ $content['stat_2_label'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <x-section-heading :kicker="$content['values_kicker']" :title="$content['values_title']" />
            <div class="row g-4">
                @foreach($content['values'] as $value)
                    <div class="col-md-3">
                        <x-award-card :icon="$value['icon']" :label="$value['label']" :description="$value['description']" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-section
        :title="$content['cta_title']"
        :text="$content['cta_text']"
        :ctaText="$content['cta_button_text']"
        :ctaUrl="route('registration')"
    />

@endsection
