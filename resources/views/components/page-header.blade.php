@props(['eyebrow' => null])
<header {{ $attributes->merge(['class' => 'page-hero']) }}>
    <div class="container">
        @isset($breadcrumb)
            {{ $breadcrumb }}
        @endisset

        @if($eyebrow)
            <div class="eyebrow">{{ $eyebrow }}</div>
        @endif

        @isset($title)
            <h1>{{ $title }}</h1>
        @endisset

        @isset($subtitle)
            <p>{{ $subtitle }}</p>
        @endisset

        {{ $slot }}
    </div>
</header>
