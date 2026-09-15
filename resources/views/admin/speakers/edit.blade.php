@extends('admin.layouts.app')

@section('title', 'Edit Speaker')

@section('content')

    <x-admin.page-heading title="Edit Speaker" />

    <form method="POST" action="{{ route('admin.speakers.update', $speaker) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.speakers._form')
    </form>

@endsection
