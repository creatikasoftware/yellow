@props(['title', 'ctaText' => null, 'ctaUrl' => null])
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">{{ $title }}</h1>
    @if($ctaText && $ctaUrl)
        <a href="{{ $ctaUrl }}" class="btn btn-dark btn-sm"><i class="bi bi-plus-lg me-1"></i>{{ $ctaText }}</a>
    @endif
</div>
