@extends('admin.layouts.app')

@section('title', 'Add Event')

@section('content')

    <x-admin.page-heading title="Add Event" />

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @include('admin.events._form')
    </form>

@endsection
