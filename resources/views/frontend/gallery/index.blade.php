@extends('layouts.app')

@section('title', "Gallery | Yellow Achiever's Award")

@section('content')

    <x-page-header eyebrow="Event Gallery">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Gallery'],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:title>Moments Worth<br>Remembering</x-slot:title>
        <x-slot:subtitle>Browse highlights from award ceremonies, summits, conversations and networking events.</x-slot:subtitle>
    </x-page-header>

    @if($categories->isNotEmpty())
        <section class="section pb-0">
            <div class="container">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('gallery.index') }}" class="btn btn-sm {{ $activeCategory ? 'btn-outline-dark' : 'btn-dark' }}">All</a>
                    @foreach($categories as $category)
                        <a href="{{ route('gallery.index', ['category' => $category->slug]) }}" class="btn btn-sm {{ $activeCategory && $activeCategory->is($category) ? 'btn-dark' : 'btn-outline-dark' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(!$featuredItem && $otherItems->isEmpty())
        <section class="section">
            <div class="container">
                <p class="text-muted text-center py-5">
                    @if($activeCategory)
                        No gallery photos in "{{ $activeCategory->name }}" yet — try another category.
                    @else
                        No gallery photos are available right now — please check back soon.
                    @endif
                </p>
            </div>
        </section>
    @else
        @php $heroCount = $featuredItem ? 4 : 0; @endphp

        @if($featuredItem)
            <section class="section">
                <div class="container">
                    <div class="row g-3">
                        <div class="col-lg-6"><x-gallery-card :item="$featuredItem" large /></div>
                        <div class="col-lg-6">
                            <div class="row g-3">
                                @foreach($otherItems->take(4) as $item)
                                    <div class="col-6"><x-gallery-card :item="$item" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($otherItems->count() > $heroCount)
            <section class="section {{ $featuredItem ? 'section-alt' : '' }}">
                <div class="container">
                    <div class="row g-3" id="galleryGrid">
                        @include('frontend.gallery._cards', ['items' => $otherItems->slice($heroCount, 12)])
                    </div>

                    <div id="galleryLoader" class="text-center py-5" data-offset="{{ $heroCount + 12 }}" data-category="{{ $activeCategory?->slug }}" style="{{ $hasMore ? '' : 'display:none' }}">
                        <div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading more photos…</span></div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    <x-gallery-lightbox />

@endsection

@push('scripts')
    <script>
        (function () {
            const loader = document.getElementById('galleryLoader');
            if (!loader) return;

            const grid = document.getElementById('galleryGrid');
            let loading = false;

            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) loadMore();
            }, { rootMargin: '400px' });

            observer.observe(loader);

            function loadMore() {
                if (loading) return;
                loading = true;

                const offset = loader.dataset.offset;
                const category = loader.dataset.category || '';
                const url = new URL('{{ route('gallery.load-more') }}', window.location.origin);
                url.searchParams.set('offset', offset);
                if (category) url.searchParams.set('category', category);

                fetch(url)
                    .then((r) => r.json())
                    .then((data) => {
                        grid.insertAdjacentHTML('beforeend', data.html);
                        loader.dataset.offset = data.nextOffset;
                        loading = false;

                        if (!data.hasMore) {
                            observer.unobserve(loader);
                            loader.style.display = 'none';
                        }
                    })
                    .catch(() => { loading = false; });
            }
        })();
    </script>
@endpush
