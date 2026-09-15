@props(['service'])
<div class="card-clean">
    @if($service->featured_image)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($service->featured_image) }}" alt="{{ $service->title }}" class="service-card-image">
    @else
        <div class="image-placeholder event-image"></div>
    @endif
    <div class="card-body-custom">
        @if($service->icon)
            <div class="mb-2"><i class="bi {{ $service->icon }}" style="font-size:26px;color:var(--gold,#d5a43b)"></i></div>
        @endif
        <h3 class="card-title">{{ $service->title }}</h3>
        @if($service->short_description)
            <p class="small-muted mt-2">{{ \Illuminate\Support\Str::limit($service->short_description, 110) }}</p>
        @endif
        <a class="arrow-link d-block mt-2" href="{{ route('services.show', $service) }}">Learn More &rarr;</a>
    </div>
</div>
