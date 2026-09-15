@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')

    <x-admin.page-heading title="Edit Testimonial" />

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.testimonials._form')
    </form>

@endsection
