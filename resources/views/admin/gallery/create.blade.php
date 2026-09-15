@extends('admin.layouts.app')

@section('title', 'Add Gallery Item')

@section('content')

    <x-admin.page-heading title="Add Gallery Item" />

    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
        @include('admin.gallery._form')
    </form>

@endsection
