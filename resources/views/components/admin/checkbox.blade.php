@props(['name', 'label', 'checked' => false])
<div class="form-check mb-3">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1" class="form-check-input" {{ old($name, $checked) ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>
