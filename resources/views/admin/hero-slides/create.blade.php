@extends('admin.layouts.app')

@section('title', 'Add Hero Slide')

@section('content')

    <x-admin.page-heading title="Add Hero Slide" />

    <form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data">
        @include('admin.hero-slides._form')
    </form>

@endsection
