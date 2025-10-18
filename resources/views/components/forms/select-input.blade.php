@props([
    'name' => '',
    'label' => '',
    'options' => [],
    'placeholder' => 'Please select an option...'
])

<div class="w-100">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-select bg-neutral-7"
        wire:model="{{ $name }}"
    >
        <option value="">{{ $placeholder }}</option>

        {{-- Loop through the options array --}}
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
