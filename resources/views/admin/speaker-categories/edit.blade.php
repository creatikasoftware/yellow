@extends('admin.layouts.app')

@section('title', 'Edit Speaker Category')

@section('content')

    <x-admin.page-heading title="Edit Speaker Category" />

    <form method="POST" action="{{ route('admin.speaker-categories.update', $speakerCategory) }}">
        @method('PUT')
        @include('admin.speaker-categories._form')
    </form>

@endsection
