@extends('admin.layouts.app')

@section('title', 'Add Speaker Category')

@section('content')

    <x-admin.page-heading title="Add Speaker Category" />

    <form method="POST" action="{{ route('admin.speaker-categories.store') }}">
        @include('admin.speaker-categories._form')
    </form>

@endsection
