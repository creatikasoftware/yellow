@props(['kicker', 'title', 'ctaText' => null, 'ctaUrl' => null])
<div class="section-head">
    <div>
        <div class="section-kicker">{{ $kicker }}</div>
        <h2 class="section-title">{{ $title }}</h2>
    </div>
    @if($ctaText && $ctaUrl)
        <a href="{{ $ctaUrl }}" class="btn btn-outline-gold">{{ $ctaText }}</a>
    @endif
</div>
