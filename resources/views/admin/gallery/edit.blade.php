@extends('admin.layouts.app')

@section('title', 'Edit Gallery Item')

@section('content')

    <x-admin.page-heading title="Edit Gallery Item" />

    <form method="POST" action="{{ route('admin.gallery.update', $galleryItem) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.gallery._form')
    </form>

@endsection
