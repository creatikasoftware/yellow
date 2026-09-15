@extends('admin.layouts.app')

@section('title', 'Edit Award Category')

@section('content')

    <x-admin.page-heading title="Edit Award Category" />

    <form method="POST" action="{{ route('admin.awards.update', $award) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.awards._form')
    </form>

@endsection
