@extends('admin.layouts.app')

@section('title', 'Edit Gallery Category')

@section('content')

    <x-admin.page-heading title="Edit Gallery Category" />

    <form method="POST" action="{{ route('admin.gallery-categories.update', $galleryCategory) }}">
        @method('PUT')
        @include('admin.gallery-categories._form')
    </form>

@endsection
