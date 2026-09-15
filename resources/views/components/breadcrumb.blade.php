@props(['items' => []])
<nav aria-label="breadcrumb" class="ya-breadcrumb">
    <ol class="breadcrumb mb-0">
        @foreach($items as $item)
            @if(!$loop->last && !empty($item['url']))
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
