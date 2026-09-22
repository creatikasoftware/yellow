<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/yellow-logo.svg') }}" alt="Yellow Achiever's Award">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('awards.*') ? 'active' : '' }}" href="{{ route('awards.index') }}">Awards</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}" href="{{ route('speakers.index') }}">Speakers</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
            </ul>
            <a class="btn btn-gold" href="{{ route('registration') }}">Register Now</a>
            <form class="ms-lg-2">
                <script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_NmVOv7FYINsYeV" async></script>
            </form>
        </div>
    </div>
</nav>
