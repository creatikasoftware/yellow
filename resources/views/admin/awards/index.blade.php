@extends('admin.layouts.app')

@section('title', 'Awards')

@section('content')

    <x-admin.page-heading title="Award Categories" ctaText="Add Category" :ctaUrl="route('admin.awards.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Short Description</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awards as $award)
                    <tr>
                        <td><i class="bi {{ $award->icon }}"></i></td>
                        <td>{{ $award->name }}</td>
                        <td class="small text-muted">{{ $award->short_description }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.awards.edit', $award) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.awards.destroy', $award)" confirm="Delete this award category?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center py-4">No award categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $awards->links() }}</div>

@endsection
