@props(['item' => null, 'large' => false])
@if($item && $item->image)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"
        alt="{{ $item->caption ?: 'Gallery photo' }}"
        class="gallery-box-image{{ $large ? ' large' : '' }}"
        style="cursor:zoom-in"
        role="button"
        data-bs-toggle="modal"
        data-bs-target="#galleryLightbox"
        data-full-src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"
        data-caption="{{ $item->caption }}"
    >
@else
    <div class="gallery-box{{ $large ? ' large' : '' }}"></div>
@endif
