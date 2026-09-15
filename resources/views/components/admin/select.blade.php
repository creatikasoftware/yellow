@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'placeholder' => null])
<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}>
        @if($placeholder)
            <option value="" disabled {{ old($name, $value) ? '' : 'selected' }}>{{ $placeholder }}</option>
        @endif
        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" {{ (string) old($name, $value) === (string) $optValue ? 'selected' : '' }}>{{ $optLabel }}</option>
        @endforeach
    </select>
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
