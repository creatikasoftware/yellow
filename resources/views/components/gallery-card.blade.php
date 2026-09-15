@props(['item' => null, 'large' => false])
@if($item && $item->image)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"
        alt="{{ $item->caption ?: 'Gallery photo' }}"
        class="gallery-box-image{{ $large ? ' large' : '' }}"
    >
@else
    <div class="gallery-box{{ $large ? ' large' : '' }}"></div>
@endif
