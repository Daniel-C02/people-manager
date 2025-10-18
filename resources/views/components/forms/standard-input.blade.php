@props([
    'type' => 'text',
    'placeholder' => '',
    'name' => '',
    'label' => '',
    'class' => '',
    'value' => '',
    'required' => false,
    'autofocus' => false,
    'autocomplete' => ''
])

<div @class([$class])>
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        class="form-control bg-neutral-7"
        placeholder="{{ $placeholder }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    >

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
