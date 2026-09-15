@props(['icon', 'label', 'description' => null, 'url' => null, 'linkText' => 'Explore Category'])
<div class="category-card">
    <i class="bi {{ $icon }}"></i>
    <span>{{ $label }}</span>
    @if($description)
        <p class="small-muted mt-3">{{ $description }}</p>
    @endif
    @if($url)
        <a href="{{ $url }}" class="arrow-link">{{ $linkText }} &rarr;</a>
    @endif
</div>
