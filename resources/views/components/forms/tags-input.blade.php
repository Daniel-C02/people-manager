@props([
    'name' => '',
    'label' => '',
    'options' => [],
    'value' => [],
    'placeholder' => 'Select interests...'
])

<div
    class="w-100"
    wire:ignore
    x-data="{
        // 1. Get the selected values from Livewire. Default to empty array.
        value: @js($value ?? []),

        // 2. Format the available options for Tom Select (e.g., ['Reading'] -> [{value: 'Reading', text: 'Reading'}])
        options: @js(collect($options)->map(fn($option) => ['value' => $option, 'text' => $option]))
    }"
    x-init="
        (() => {
            // 3. Initialize Tom Select
            const select = new TomSelect($refs.input, {
                plugins: ['remove_button'], // Adds the 'x' to remove tags
                options: options,          // Use the formatted options
                items: value,              // Set the pre-selected items
                placeholder: '{{ $placeholder }}',
                create: false,             // Prevent users from creating new interests

                // 4. Bridge to Livewire: Send updates
                onChange: (selectedValues) => {
                    value = selectedValues;
                    @this.set('{{ $name }}', selectedValues); // Update the Livewire property
                }
            });

            // 5. Bridge from Livewire: Watch for external changes
            Livewire.on('updated-input-{{ $name }}', (event) => {
                const newValue = event[0].value;
                if (JSON.stringify(newValue) !== JSON.stringify(select.items)) {
                    select.setValue(newValue, false); // Update TomSelect without triggering onChange
                }
            });
        })();
    "
>
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        x-ref="input"
        multiple
        class="form-control bg-neutral-7"
    >
        {{-- You can pre-populate options for non-JS fallback --}}
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
