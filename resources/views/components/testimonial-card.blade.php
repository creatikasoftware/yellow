@props(['testimonial'])
<div class="card-clean ya-testimonial-card">
    @if($testimonial->photo)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="ya-testimonial-photo">
    @else
        <div class="ya-testimonial-photo-placeholder"></div>
    @endif
    <div class="ya-testimonial-body">
        <p class="ya-testimonial-quote">&ldquo;{{ $testimonial->quote }}&rdquo;</p>
        <h4 class="ya-testimonial-name">{{ $testimonial->name }}</h4>
        <span class="ya-testimonial-role">{{ $testimonial->role_company }}</span>
    </div>
</div>
