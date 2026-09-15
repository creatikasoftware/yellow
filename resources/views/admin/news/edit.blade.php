@extends('admin.layouts.app')

@section('title', 'Edit Article')

@section('content')

    <x-admin.page-heading title="Edit Article" />

    <form method="POST" action="{{ route('admin.news.update', $newsArticle) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.news._form')
    </form>

@endsection
