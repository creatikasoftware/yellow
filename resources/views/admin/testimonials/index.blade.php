@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')

    <x-admin.page-heading title="Testimonials" ctaText="Add Testimonial" :ctaUrl="route('admin.testimonials.create')" />

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role / Company</th>
                    <th>Rating</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->name }}</td>
                        <td class="small text-muted">{{ $testimonial->role_company }}</td>
                        <td>{{ $testimonial->rating }}/5</td>
                        <td>{{ $testimonial->is_featured ? 'Yes' : '' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.testimonials.destroy', $testimonial)" confirm="Delete this testimonial?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">No testimonials yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $testimonials->links() }}</div>

@endsection
