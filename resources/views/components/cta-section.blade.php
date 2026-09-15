@props(['title', 'text', 'ctaText', 'ctaUrl'])
<div class="cta-strip">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>{{ $title }}</h2>
            <p>{{ $text }}</p>
        </div>
        <a class="btn btn-dark" href="{{ $ctaUrl }}">{{ $ctaText }} &rarr;</a>
    </div>
</div>
