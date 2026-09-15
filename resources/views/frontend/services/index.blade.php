@extends('layouts.app')

@section('title', "Our Services | Yellow Achiever's Award")
@section('meta_description', "Explore the full range of services offered by Yellow Achiever's Award — from award ceremonies to corporate event management.")

@section('content')

    <x-page-header eyebrow="What We Offer">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Our<br>Services</x-slot:title>
        <x-slot:subtitle>Everything we do to help you recognize achievement, host memorable events and build lasting connections.</x-slot:subtitle>
    </x-page-header>

    <section class="section">
        <div class="container">
            @if($services->isEmpty())
                <p class="text-muted text-center py-5">No services are available right now — please check back soon.</p>
            @else
                <div class="row g-4">
                    @foreach($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <x-service-card :service="$service" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">{{ $services->links() }}</div>
            @endif
        </div>
    </section>

@endsection
