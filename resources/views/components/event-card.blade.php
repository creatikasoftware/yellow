@props(['event', 'compact' => false, 'past' => false])
<div class="card-clean{{ $past ? ' opacity-75' : '' }}">
    <div class="position-relative">
        @if($event->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}" alt="{{ $event->title }}" class="event-image" style="width:100%;height:220px;object-fit:cover{{ $past ? ';filter:grayscale(60%)' : '' }}">
        @else
            <div class="image-placeholder event-image"></div>
        @endif
        @if($past)
            <span class="badge bg-secondary position-absolute top-0 end-0 m-2">Completed</span>
        @endif
    </div>
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
