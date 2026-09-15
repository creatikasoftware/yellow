@extends('admin.layouts.app')

@section('title', 'Partners')

@section('content')

    <x-admin.page-heading title="Partners" ctaText="Add Partner" :ctaUrl="route('admin.partners.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" style="height:32px">
                            @else
                                <span class="text-muted small">Text only</span>
                            @endif
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.partners.destroy', $partner)" confirm="Delete this partner?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center py-4">No partners yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $partners->links() }}</div>

@endsection
