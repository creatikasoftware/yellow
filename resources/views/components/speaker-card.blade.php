@props(['speaker', 'withLink' => true])
<div class="card-clean">
    @if($speaker->photo)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($speaker->photo) }}" alt="{{ $speaker->name }}" class="speaker-image" style="width:100%;object-fit:cover">
    @else
        <div class="speaker-image"></div>
    @endif
    <div class="speaker-info">
        <h4>{{ $speaker->name }}</h4>
        <small>{{ $speaker->role }}</small>
        @if($withLink)
            <div><a class="arrow-link d-inline-block mt-2" href="{{ route('speakers.show', $speaker->slug) }}">View Profile &rarr;</a></div>
        @endif
    </div>
</div>
