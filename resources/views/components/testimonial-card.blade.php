@props(['testimonial', 'featured' => false, 'label' => 'EVENT PARTNER'])
@if($featured)
    <div class="ya-featured-testimonial">
        <div class="ya-large-quote">&ldquo;</div>
        <div class="ya-featured-content">
            <div class="ya-stars">
                @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                    <i class="bi bi-star-fill"></i>
                @endfor
            </div>
            <div class="ya-featured-label">{{ $label }}</div>
            <blockquote>{{ $testimonial->quote }}</blockquote>
        </div>
        <div class="ya-featured-footer">
            <div class="ya-profile">
                <div class="ya-avatar">{{ $testimonial->avatar_initials }}</div>
                <div class="ya-profile-info">
                    <strong>{{ $testimonial->name }}</strong>
                    <span>{{ $testimonial->role_company }}</span>
                </div>
            </div>
            <div class="ya-verified"><i class="bi bi-patch-check-fill"></i> Verified Client</div>
        </div>
    </div>
@else
    <div class="ya-small-testimonial">
        <div class="ya-small-header">
            <div class="ya-small-profile">
                <div class="ya-small-avatar">{{ $testimonial->avatar_initials }}</div>
                <div>
                    <strong>{{ $testimonial->name }}</strong>
                    <span>{{ $testimonial->role_company }}</span>
                </div>
            </div>
            <div class="ya-small-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        </div>
        <p>{{ $testimonial->quote }}</p>
    </div>
@endif
