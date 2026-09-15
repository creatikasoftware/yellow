@props(['name', 'label', 'value' => null, 'required' => false, 'rows' => 4, 'help' => null])
<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" class="form-control @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
    @if($help)<div class="form-text">{{ $help }}</div>@endif
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
