@props(['name', 'label', 'current' => null, 'help' => null])
<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    @if($current)
        <div class="mb-2">
            <img src="{{ \Illuminate\Support\Facades\Storage::url($current) }}" alt="" style="height:70px;border-radius:6px;object-fit:cover">
        </div>
    @endif
    <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control @error($name) is-invalid @enderror" accept="image/*">
    @if($help)<div class="form-text">{{ $help }}</div>@endif
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
