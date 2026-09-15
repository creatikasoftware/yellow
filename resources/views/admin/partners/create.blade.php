@extends('admin.layouts.app')

@section('title', 'Add Partner')

@section('content')

    <x-admin.page-heading title="Add Partner" />

    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
        @include('admin.partners._form')
    </form>

@endsection
