@extends('admin.layouts.app')

@section('title', 'Add Testimonial')

@section('content')

    <x-admin.page-heading title="Add Testimonial" />

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @include('admin.testimonials._form')
    </form>

@endsection
