@props(['event', 'compact' => false])
<div class="card-clean">
    <div class="image-placeholder event-image"></div>
    <div class="card-body-custom">
        <div class="meta">{{ $event->starts_at->format('d M Y') }}</div>

        @if($compact)
            <div class="card-title">{{ $event->title }}</div>
            <div class="small-muted">{{ $event->location }}</div>
            <a class="arrow-link d-block mt-3" href="{{ route('events.show', $event->slug) }}">View Details &rarr;</a>
        @else
            <h3 class="card-title">{{ $event->title }}</h3>
            <div class="small-muted"><i class="bi bi-geo-alt"></i> {{ $event->location }}</div>
            @if(!empty($event->summary))
                <p class="small-muted mt-2">{{ $event->summary }}</p>
            @endif
            <a class="arrow-link" href="{{ route('events.show', $event->slug) }}">Event Details &rarr;</a>
        @endif
    </div>
</div>
