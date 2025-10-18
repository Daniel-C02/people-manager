@props([
    'type' => "text",
    'placeholder' => "",
    'name' => "",
    'label' => "",
    'disabled' => false,
    'class' => ""
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
        @if($disabled) disabled @endif
        wire:model.live.defer="{{ $name }}"
    >

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
