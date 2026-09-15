@props(['speaker', 'withLink' => true])
<div class="card-clean">
    <div class="speaker-image"></div>
    <div class="speaker-info">
        <h4>{{ $speaker->name }}</h4>
        <small>{{ $speaker->role }}</small>
        @if($withLink)
            <div><a class="arrow-link d-inline-block mt-2" href="{{ route('speakers.show', $speaker->slug) }}">View Profile &rarr;</a></div>
        @endif
    </div>
</div>
