@extends('admin.layouts.app')

@section('title', 'Edit Hero Slide')

@section('content')

    <x-admin.page-heading title="Edit Hero Slide" />

    <form method="POST" action="{{ route('admin.hero-slides.update', $heroSlide) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.hero-slides._form')
    </form>

@endsection
