<?php

namespace App\Livewire;

use App\Models\Person;
use App\Traits\CreatePersonTrait; // Trait for handling the create/edit modal logic
use App\Traits\WireAlertTrait; // Trait for showing SweetAlert popups
use Livewire\WithPagination; // Trait for handling pagination
use Livewire\Component;

class PeopleManager extends Component
{
    // Import all the traits
    use WithPagination, WireAlertTrait, CreatePersonTrait;

    /* Search query parameter for the table */
    // This is bound to the search input field
    public string $search = "";

    /* Array of the selected items */
    // This stores the IDs of the selected checkboxes
    public array $selected_items = [];

    /* Indicating if all items within the current page has been selected */
    // This is bound to the "select all" checkbox in the table header
    public bool $select_all_current_page = false;

    /*
     * Render the PeopleManager Livewire component
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        // Get the paginated list of people, applying any search filters
        $people = $this->findPeople()->paginate(10);

        // Sync the "select all" checkbox state
        // Get all the IDs visible on the *current* page
        $current_page_ids = $people->pluck('id')->map(fn ($id) => (string) $id)->toArray();

        // Check if all current page IDs are in the $selected_items array
        $this->select_all_current_page = !empty($current_page_ids) &&
            count(array_intersect($this->selected_items, $current_page_ids)) === count($current_page_ids);

        // Pass the people data to the view
        return view('livewire.people-manager', [
            'people' => $people
        ]);
    }

    /*
     * Applies filtering on the People returned to the page
     */
    private function findPeople()
    {
        // Start with a base query
        $query = Person::query();

        // Apply search only if the $search property is not empty
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            // Group the where clauses to ensure correct SQL logic (A OR B OR C)
            $query->where(function ($q) use($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('surname', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('mobile_number', 'like', $searchTerm)
                    ->orWhere('south_african_id', 'like', $searchTerm)
                    ->orWhere('language', 'like', $searchTerm)
                    ->orWhereHas('interests', function ($interestQuery) use ($searchTerm) {
                        $interestQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Return the query builder, ordered by newest first
        return $query->latest();
    }

    /*
     * Handle the state of the main table checkbox in order to select all entries.
     */
    // This method is automatically called when $select_all_current_page is updated
    public function updatedSelectAllCurrentPage(bool $value): void
    {
        // Re-run the query to get IDs for the *current* filtered and paginated view
        $query = $this->findPeople();

        // Get the list of IDs on the current page
        $current_page_ids = $query
            ->paginate(10)
            ->pluck('id')
            ->map(fn ($id) => (string) $id) // Cast to string for consistent comparison
            ->toArray();

        if ($value) {
            // If the "select all" box was checked, add all current IDs to the selected array
            $this->selected_items = $current_page_ids;
        } else {
            // If it was unchecked, remove all current IDs from the selected array
            $this->selected_items = array_diff($this->selected_items, $current_page_ids);
        }
    }

    /**
     * Bulk Action: delete all selected entries.
     */
    public function deleteSelected(): void
    {
        // Do nothing if no items are selected
        if (empty($this->selected_items)) {
            $this->sendAlert('info', 'No items selected.');
            return;
        }

        // Get the count for the success message
        $count = count($this->selected_items);
        // Delete all people whose IDs are in the $selected_items array
        Person::whereIn('id', $this->selected_items)->delete();

        // Reset the selection
        $this->selected_items = [];
        $this->select_all_current_page = false;

        // Show a success popup
        $this->sendAlert('success', "$count items deleted successfully.");
    }

    /**
     * Sets the component state to edit an existing person.
     *
     * This populates the form properties with the person's data
     * and dispatches an event to show the modal in edit mode.
     */
    // This method is called from the "edit" button in the table row
    public function editPerson(Person $person): void
    {
        // Populate all the form properties (from CreatePersonTrait)
        // with the data from the selected person
        $this->name = $person->name;
        $this->surname = $person->surname;
        $this->email = $person->email;
        $this->south_african_id = $person->south_african_id;
        $this->mobile_number = $person->mobile_number;
        $this->birth_date = $person->birth_date;
        $this->language = $person->language;
        // Pluck the names from the related interests (e.g., ["Reading", "Hiking"])
        $this->interests = $person->interests->pluck('name')->toArray();

        // Dispatch events to update the JS-controlled inputs
        $this->dispatch('updated-input-interests', ['value' => $this->interests]);
        $this->dispatch('updated-input-birth_date', ['value' => $this->birth_date]);
        $this->dispatch('updated-input-mobile_number', ['value' => $this->mobile_number]);

        // Set the modal state to 'editing'
        $this->is_editing = true;
        $this->person_to_edit = $person;

        // Dispatch an event to show the modal (handled by Alpine.js)
        $this->dispatch('show-create-person-modal');
    }
}
