@extends('admin.layouts.app')

@section('title', 'Add Gallery Category')

@section('content')

    <x-admin.page-heading title="Add Gallery Category" />

    <form method="POST" action="{{ route('admin.gallery-categories.store') }}">
        @include('admin.gallery-categories._form')
    </form>

@endsection
