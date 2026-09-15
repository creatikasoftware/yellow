@extends('admin.layouts.app')

@section('title', 'Add Article')

@section('content')

    <x-admin.page-heading title="Add Article" />

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @include('admin.news._form')
    </form>

@endsection
