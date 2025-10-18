@props([
    'id' => "",
    'modalSize' => "",
    'isEditing' => false,
])

<x-modals.wrapper
    id="{{ $id }}"
    modalSize="{{ $modalSize }}"
>
    <div
        class="modal-dialog"
        x-data
        x-init="
            (() => {
                const modal = new bootstrap.Modal('#{{ $id }}');
                Livewire.on('show-create-person-modal', () => {
                    modal.show();
                });
            })();
        "
    >
        <div class="modal-content">
            <form class="p-8" wire:submit.prevent="savePerson">
                {{-- Title --}}
                <h3 class="pb-6">
                    <span class="text-primary-5">{{ $isEditing ? 'Update' : 'Create' }}</span>
                    <span class="text-secondary-5">Person</span>
                </h3>

                {{-- Form Elements --}}
                <div class="d-flex flex-column gap-6">
                    <div class="d-flex row-gap-6 column-gap-5">
                        <x-forms.input
                            type="text"
                            placeholder="Name"
                            name="name"
                            label="Full name"
                            class="w-100"
                        />
                        <x-forms.input
                            type="text"
                            placeholder="Surname"
                            name="surname"
                            label="Surname"
                            class="w-100"
                        />
                    </div>
                    <div class="d-flex row-gap-6 column-gap-5">
                        <x-forms.input
                            type="email"
                            placeholder="Email"
                            name="email"
                            label="Email Address"
                            :disabled="$isEditing"
                            class="w-100"
                        />
                        <x-forms.input
                            type="text"
                            placeholder="South African Id"
                            name="south_african_id"
                            label="South African Id Number"
                            :disabled="$isEditing"
                            class="w-100"
                        />
                    </div>
                    <div class="d-flex row-gap-6 column-gap-5">
                        <x-forms.phone-input
                            placeholder=" 72 123 4567"
                            name="mobile_number"
                            label="Mobile Number"
                            :value="$this->mobile_number"
                        />
                        <x-forms.date-input
                            name="birth_date"
                            placeholder="Please select your birth date"
                            label="Birth Date"
                            :value="$this->birth_date"
                        />
                    </div>
                    <div class="d-flex row-gap-6 column-gap-5">
                        <x-forms.select-input
                            label="Language"
                            name="language"
                            :options="App\Options\LanguageOptions::get()"
                            placeholder="Select your language"
                        />
                        <x-forms.tags-input
                            label="Interests"
                            name="interests"
                            :options="App\Options\InterestOptions::get()"
                            placeholder="Add interests..."
                            :value="$this->interests"
                        />
                    </div>
                </div>


                {{-- Action buttons --}}
                <div class="d-flex gap-6 pt-8 mt-6">
                    <button type="button" class="btn btn-secondary w-100" wire:click="dismissPersonCreation">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ $isEditing ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-modals.wrapper>
