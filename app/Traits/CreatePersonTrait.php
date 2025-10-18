<?php

namespace App\Traits;

use App\Mail\WelcomeEmail;
use App\Models\Interest;
use App\Models\Person;
use App\Options\InterestOptions;
use App\Options\LanguageOptions;
use App\Rules\SouthAfricanIdNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

trait CreatePersonTrait
{
    // Form state properties
    // These are bound to the modal's input fields
    public string $name = "";
    public string $surname = "";
    public string $email = "";
    public string $south_african_id = "";
    public ?string $mobile_number = "";
    public ?string $birth_date = "";
    public string $language = "";
    public array $interests = [];

    // Edit state properties
    // Used to track if the modal is in 'create' or 'edit' mode
    public bool $is_editing = false;
    public ?Person $person_to_edit = null;

    /**
     * Define the validation rules.
     *
     * @return array
     */
    protected function rules(): array
    {
        // When editing, we need to ignore the current person's email
        // so the validation doesn't fail on its own email.
        $emailRule = $this->is_editing && $this->person_to_edit
            ? Rule::unique('people', 'email')->ignore($this->person_to_edit->id)
            : 'unique:people,email';

        // Same for the South African ID
        $saIdRule = $this->is_editing && $this->person_to_edit
            ? Rule::unique('people', 'south_african_id')->ignore($this->person_to_edit->id)
            : 'unique:people,south_african_id';

        // Return the final array of rules
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:220',
                $emailRule // Use the dynamic email rule
            ],

            'south_african_id' => [
                'required',
                'string',
                new SouthAfricanIdNumber(), // Custom validation rule
                $saIdRule // Use the dynamic ID rule
            ],

            'mobile_number' => [
                'required',
                'string',
                'regex:/^\+27[0-9]{9}$/' // Regex for +27 format
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today' // Can't be a future date
            ],

            'language' => [
                'required',
                'string',
                Rule::in(LanguageOptions::get()) // Must be one of the predefined options
            ],

            // Interests are optional, but if provided, must be an array of strings
            'interests' => ['nullable', 'array'],
            'interests.*' => ['string', Rule::in(InterestOptions::get())],
        ];
    }

    /**
     * Dismisses the creation of a person
     */
    public function dismissPersonCreation():void
    {
        // Dispatch a browser event to close the modal (handled by Alpine.js)
        $this->dispatch('close-modals');
        // Reset all public properties (name, email, etc.)
        $this->reset();
        // Reset JS-controlled inputs (like date/phone)
        $this->resetJsInputValues();
        // Clear any old validation errors
        $this->resetValidation();
        // Reset the edit state
        $this->is_editing = false;
        $this->person_to_edit = null;
    }

    /**
     * Resets specific form elements that livewire has no control over since they are being wire:ignore
     */
    private function resetJsInputValues(): void
    {
        // Dispatch events to clear the JS-powered inputs
        $this->dispatch('updated-input-interests', ['value' => []]);
        $this->dispatch('updated-input-birth_date', ['value' => null]);
        $this->dispatch('updated-input-mobile_number', ['value' => null]);
    }

    /**
     * Validate and save (or update) the person and their interests.
     */
    public function savePerson(): void
    {
        // 1. Run validation and get the validated data
        // This uses the rules() method defined above
        $validatedData = $this->validate();

        // 2. Use a transaction to ensure data integrity
        // If any part fails (e.g., saving interests), the person won't be created.
        DB::transaction(function () use ($validatedData) {

            // Consolidate data for create/update
            // This array holds all the fields for the Person model
            $personData = [
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'email' => $validatedData['email'],
                'south_african_id' => $validatedData['south_african_id'],
                'mobile_number' => $validatedData['mobile_number'],
                'birth_date' => $validatedData['birth_date'],
                'language' => $validatedData['language'],
            ];

            // 3. Create or Update the Person
            // Check if we are in 'edit' mode
            if ($this->is_editing && $this->person_to_edit) {
                // We are in edit mode, update the existing person
                $this->person_to_edit->update($personData);
                $person = $this->person_to_edit; // Use the updated person for interest syncing
            } else {
                // We are in create mode
                $person = Person::create($personData);

                // On capturing a person: An email needs to be sent out to the person
                // captured informing them that they’ve been captured on the system.
                // Send the welcome email only on creation
                Mail::to($person->email)->send(new WelcomeEmail($person));
            }

            // 4. Handle the many-to-many relationship for interests
            $interestIds = [];
            // Check if any interests were submitted
            if (!empty($validatedData['interests'])) {
                // Loop through the interest names (e.g., "Reading", "Hiking")
                foreach ($validatedData['interests'] as $interestName) {
                    // Find the interest by name, or create it if it's new
                    $interest = Interest::firstOrCreate(['name' => $interestName]);
                    // Add the ID to our array
                    $interestIds[] = $interest->id;
                }
            }

            // 5. Sync interests.
            // sync() attaches all IDs in $interestIds and detaches any not present.
            // If $interestIds is empty, this will detach all interests.
            $person->interests()->sync($interestIds);
        }); // End of the database transaction

        // 6. Set the alert message based on the action
        $message = $this->is_editing
            ? 'Person has been updated successfully.'
            : 'A new person has been created successfully.';

        // 7. Close the modal and fire a sweetalert
        // sendAlert() is from the WireAlertTrait
        $this->sendAlert('success', $message);

        // 8. Reset the form fields and state (is_editing, person_to_edit)
        // This is the same as the dismiss method
        $this->reset();
        $this->resetJsInputValues();
        $this->is_editing = false;
        $this->person_to_edit = null;
    }
}
