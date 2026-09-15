@extends('admin.layouts.app')

@section('title', 'News')

@section('content')

    <x-admin.page-heading title="News" ctaText="Add Article" :ctaUrl="route('admin.news.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Published</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td class="small text-muted">{{ $article->published_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.news.destroy', $article)" confirm="Delete this article?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center py-4">No articles yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $articles->links() }}</div>

@endsection
