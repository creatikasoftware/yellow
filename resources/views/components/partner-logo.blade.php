@props(['partner'])
<div class="col-6 col-md-2 partner">
    @if(!empty($partner->logo))
        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}">
    @else
        {{ $partner->name }}
    @endif
</div>
