@extends('admin.layouts.app')

@section('title', 'Add Service')

@section('content')

    <x-admin.page-heading title="Add Service" />

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @include('admin.services._form')
    </form>

@endsection
