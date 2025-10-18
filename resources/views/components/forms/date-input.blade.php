@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'placeholder' => 'Select a date...',
])

<div class="w-100">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="w-100" wire:ignore>
        <input
            x-data="{
                // Set the initial value from the Livewire component
                value: @js($value)
            }"
            x-init="
                (() => {
                    // Initialize Flatpickr
                    const picker = flatpickr($el, {
                        // Configuration Options

                        // Show a human-friendly date to the user
                        altInput: true,
                        altFormat: 'd F Y', // e.g., '22 July 2004'

                        // Send a database-friendly date to the server
                        dateFormat: 'Y-m-d', // e.g., '2004-07-22'

                        // Set the initial date from the 'value' prop
                        defaultDate: value,

                        // For a birth date, prevent selecting future dates
                        maxDate: 'today',

                        // Reasonable DOB lower bound
                        minDate: '1900-01-01',

                        // The magic: This function runs whenever a date is selected
                        onChange: function(selectedDates, dateStr, instance) {
                            // 1. Update our Alpine 'value' variable
                            this.value = dateStr;

                            // 2. Send the new date string back to Livewire
                            @this.set('{{ $name }}', dateStr);
                        },
                    });

                    // Bridge from Livewire: Watch for external changes
                    Livewire.on('updated-input-{{ $name }}', (event) => {
                        const newValue = event[0].value;
                        picker.setDate(newValue);
                    });
                })();
            "
            type="text"
            class="form-control bg-neutral-7"
            placeholder="{{ $placeholder }}"
            name="{{ $name }}"
            readonly="readonly" {{-- Prevents manual text entry --}}
        >
    </div>

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
