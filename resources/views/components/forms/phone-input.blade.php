@props([
    'placeholder' => "",
    'name' => "",
    'label' => '',
    'value' => ""
])

<div class="w-100">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="w-100" wire:ignore>
        <input
            x-data="{
                // Store the initial value from Livewire
                value: @js($value)
            }"
            x-init="
                (() => {
                    // 1. Initialize with your correct loadUtils method
                    const iti = intlTelInput($el, {
                        initialCountry: 'za',
                        separateDialCode: true,
                        placeholderNumberType: 'MOBILE',
                        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.3/build/js/utils.js')
                    });

                    // 2. Set the initial value if one was passed
                    if (value) {
                        iti.setNumber(value);
                    }

                    // 3. Listen for changes and update Livewire
                    // 'change' triggers on blur. Use 'keyup' for live-as-you-type.
                    $el.addEventListener('change', () => {
                        let numberToSend = null;

                        // Check if the user has actually typed something
                        if ($el.value.trim() !== '') {
                            // Get the full number, even if it's invalid
                            numberToSend = iti.getNumber();
                        }

                        // Send the value (or null) to Livewire
                        @this.set('{{ $name }}', numberToSend);
                    });

                    // 4. Bridge from Livewire: Watch for external changes
                    Livewire.on('updated-input-{{ $name }}', (event) => {
                        const newValue = event[0].value;
                        $el.value = newValue;
                        if(newValue !== null) { iti.setNumber(newValue); }
                    });
                })();
            "
            type="text"
            class="form-control bg-neutral-7"
            placeholder="{{ $placeholder }}"
            name="{{ $name }}"
        >
    </div>

    @error($name) <span class="error_el">{{ $message }}</span> @enderror
</div>
