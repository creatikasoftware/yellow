@extends('admin.layouts.app')

@section('title', 'Services')

@section('content')

    <x-admin.page-heading title="Services" ctaText="Add Service" :ctaUrl="route('admin.services.create')" />

    <form method="GET" class="row g-2 mb-3">
        <div class="col-sm-5 col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by title or description&hellip;">
        </div>
        <div class="col-6 col-sm-3 col-md-2">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="col-6 col-sm-3 col-md-2">
            <select name="featured" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Featured &amp; not</option>
                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured only</option>
                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not featured</option>
            </select>
        </div>
        <div class="col-sm-auto">
            <button type="submit" class="btn btn-sm btn-outline-dark">Search</button>
            @if(request()->anyFilled(['search', 'status', 'featured']))
                <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </div>
    </form>

    <div class="card">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td class="text-muted small">{{ $service->sort_order }}</td>
                        <td>
                            {{ $service->title }}
                            <div class="small text-muted">/services/{{ $service->slug }}</div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.services.toggle-status', $service) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent">
                                    <span class="badge bg-{{ $service->status ? 'success' : 'secondary' }}">{{ $service->status ? 'Published' : 'Draft' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.services.toggle-featured', $service) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent">
                                    @if($service->featured)
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    @else
                                        <span class="badge bg-light text-muted border">Not featured</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('services.show', $service) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View on site"><i class="bi bi-box-arrow-up-right"></i></a>
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <x-admin.delete-button :action="route('admin.services.destroy', $service)" confirm="Delete this service?" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">No services found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $services->links() }}</div>

@endsection
