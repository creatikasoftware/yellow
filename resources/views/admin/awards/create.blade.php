@extends('admin.layouts.app')

@section('title', 'Add Award Category')

@section('content')

    <x-admin.page-heading title="Add Award Category" />

    <form method="POST" action="{{ route('admin.awards.store') }}" enctype="multipart/form-data">
        @include('admin.awards._form')
    </form>

@endsection
