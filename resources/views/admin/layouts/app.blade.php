<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Yellow Achiever's Award</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body{background:#f4f5f7}
        .admin-sidebar{min-height:100vh;background:#0b1118;color:#d5d9de;width:230px;flex-shrink:0}
        .admin-sidebar .brand{padding:20px;border-bottom:1px solid rgba(255,255,255,.08)}
        .admin-sidebar .brand img{width:130px}
        .admin-sidebar .nav-link{color:#aeb4ba;font-size:14px;font-weight:600;padding:10px 20px;border-radius:0}
        .admin-sidebar .nav-link.active,.admin-sidebar .nav-link:hover{color:#fff;background:rgba(255,255,255,.06)}
        .admin-sidebar .nav-link.active{border-right:3px solid var(--gold,#d5a43b)}
        .admin-sidebar .nav-section{padding:16px 20px 4px;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#6b7078}
        .admin-topbar{background:#fff;border-bottom:1px solid #e8e5de;padding:14px 24px}
        .admin-content{padding:28px;flex:1;min-width:0}
        .admin-wrap{display:flex}
        .card-stat{border:1px solid #e8e5de;border-radius:10px;background:#fff;padding:20px}
        .card-stat strong{font-size:28px;display:block}
        .table thead{background:#f8f7f4}
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrap">
        <aside class="admin-sidebar">
            <div class="brand">
                <img src="{{ asset('images/yellow-achievers-logo.webp') }}" alt="Yellow Achiever's Award">
            </div>
            <nav class="nav flex-column py-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-2"></i>Dashboard</a>

                <div class="nav-section">Pages</div>
                <a class="nav-link {{ request()->routeIs('admin.pages.home') ? 'active' : '' }}" href="{{ route('admin.pages.home') }}"><i class="bi bi-house me-2"></i>Home</a>
                <a class="nav-link {{ request()->routeIs('admin.pages.about') ? 'active' : '' }}" href="{{ route('admin.pages.about') }}"><i class="bi bi-info-circle me-2"></i>About Us</a>
                <a class="nav-link {{ request()->routeIs('admin.pages.contact') ? 'active' : '' }}" href="{{ route('admin.pages.contact') }}"><i class="bi bi-envelope-paper me-2"></i>Contact</a>

                <div class="nav-section">Content</div>
                <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}"><i class="bi bi-gear me-2"></i>Services</a>
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="bi bi-calendar3 me-2"></i>Events</a>
                <a class="nav-link {{ request()->routeIs('admin.awards.*') ? 'active' : '' }}" href="{{ route('admin.awards.index') }}"><i class="bi bi-trophy me-2"></i>Awards</a>
                <a class="nav-link {{ request()->routeIs('admin.speakers.*') ? 'active' : '' }}" href="{{ route('admin.speakers.index') }}"><i class="bi bi-mic me-2"></i>Speakers</a>
                <a class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}"><i class="bi bi-images me-2"></i>Gallery</a>
                <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper me-2"></i>News</a>
                <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}"><i class="bi bi-building me-2"></i>Partners</a>
                <a class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}"><i class="bi bi-chat-quote me-2"></i>Testimonials</a>

                <div class="nav-section">Submissions</div>
                <a class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}" href="{{ route('admin.registrations.index') }}"><i class="bi bi-person-check me-2"></i>Registrations</a>
                <a class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}"><i class="bi bi-envelope me-2"></i>Contact Messages</a>
            </nav>
        </aside>

        <div class="flex-grow-1 d-flex flex-column">
            <div class="admin-topbar d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}" target="_blank" class="text-decoration-none small text-muted"><i class="bi bi-box-arrow-up-right me-1"></i>View site</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="small text-muted">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-secondary">Logout</button>
                    </form>
                </div>
            </div>

            <div class="admin-content">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
