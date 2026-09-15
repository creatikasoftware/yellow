<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $__title = trim($__env->yieldContent('title', "Yellow Achiever's Award"));
        $__description = trim($__env->yieldContent('meta_description'));
        $__canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
        $__ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/yellow-achievers-logo.webp');
    @endphp
    <title>{{ $__title }}</title>
    @if($__description)
        <meta name="description" content="{{ $__description }}">
    @endif
    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')">
    @endif
    <link rel="canonical" href="{{ $__canonical }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Yellow Achiever's Award">
    <meta property="og:title" content="{{ $__title }}">
    @if($__description)
        <meta property="og:description" content="{{ $__description }}">
    @endif
    <meta property="og:url" content="{{ $__canonical }}">
    <meta property="og:image" content="{{ $__ogImage }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <x-navigation />

    @yield('content')

    <x-footer :extended="$extended ?? false" :awards="$footerAwards ?? []" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
