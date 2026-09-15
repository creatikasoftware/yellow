@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')

    <x-admin.page-heading title="Edit Event" />

    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.events._form')
    </form>

@endsection
