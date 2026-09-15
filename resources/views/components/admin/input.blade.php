@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'help' => null])
<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" class="form-control @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}>
    @if($help)<div class="form-text">{{ $help }}</div>@endif
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
