@extends('admin.layouts.app')

@section('title', 'Add Speaker')

@section('content')

    <x-admin.page-heading title="Add Speaker" />

    <form method="POST" action="{{ route('admin.speakers.store') }}" enctype="multipart/form-data">
        @include('admin.speakers._form')
    </form>

@endsection
