@extends('admin.layouts.app')

@section('title', 'Terms & Conditions Page Content')

@section('content')

    <x-admin.page-heading title="Terms & Conditions Page Content" />

    <form method="POST" action="{{ route('admin.pages.terms.update') }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <x-admin.input name="title" label="Page Title" :value="$content['title']" required />
                <x-admin.rich-editor name="body" label="Terms Content" :value="$content['body']" help="Supports headings, lists, links and embedded media." />
                <button type="submit" class="btn btn-dark mt-2">Save Terms & Conditions</button>
            </div>
        </div>
    </form>

@endsection
