@props(['extended' => false, 'awards' => []])
@php
    $site = \App\Support\PageContent::get('site');
    $socialLinks = [
        'facebook' => $site['social_facebook'],
        'twitter-x' => $site['social_twitter'],
        'linkedin' => $site['social_linkedin'],
        'instagram' => $site['social_instagram'],
        'youtube' => $site['social_youtube'],
    ];
@endphp
<footer>
    <div class="container">
        <div class="row g-5">
            <div class="{{ $extended ? 'col-lg-3' : 'col-lg-5' }}">
                <img class="footer-logo mb-3" src="{{ asset('images/yellow-achievers-logo.webp') }}" alt="Yellow Achiever's Award">
                <p class="footer-copy">{{ $site['footer_copy'] }}</p>
                <form class="mt-3">
                    <script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_NmVOv7FYINsYeV" async></script>
                </form>
                <div class="social mt-3">
                    @foreach($socialLinks as $icon => $url)
                        <a href="{{ $url ?: '#' }}"><i class="bi bi-{{ $icon }}"></i></a>
                    @endforeach
                </div>
            </div>

            <div class="{{ $extended ? 'col-lg-3' : 'col-6 col-lg-3' }}">
                <div class="footer-title">Quick Links</div>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('services.index') }}">Services</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('awards.index') }}">Awards</a></li>
                    <li><a href="{{ route('speakers.index') }}">Speakers</a></li>
                    <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                    <li><a href="{{ route('news.index') }}">News</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            @if($extended)
                <div class="col-lg-3">
                    <div class="footer-title">Awards Categories</div>
                    <ul class="footer-links">
                        @foreach($awards as $award)
                            <li><a href="{{ route('awards.show', $award->slug) }}">{{ $award->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="{{ $extended ? 'col-lg-3' : 'col-6 col-lg-4' }}">
                <div class="footer-title">Contact Us</div>
                <ul class="footer-links">
                    <li><i class="bi bi-geo-alt text-warning me-2"></i> {{ $site['contact_address'] }}</li>
                    <li><i class="bi bi-telephone text-warning me-2"></i> {{ $site['contact_phone'] }}</li>
                    <li><i class="bi bi-envelope text-warning me-2"></i> {{ $site['contact_email'] }}</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between flex-wrap gap-2">
            <span>&copy; {{ date('Y') }} Yellow Achiever's Award. All Rights Reserved.</span>
            <span>Privacy Policy &nbsp; | &nbsp; Terms &amp; Conditions</span>
        </div>
    </div>
</footer>
