@extends('admin.layouts.app')

@section('title', 'Edit Partner')

@section('content')

    <x-admin.page-heading title="Edit Partner" />

    <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.partners._form')
    </form>

@endsection
