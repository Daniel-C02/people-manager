<?php

namespace App\Livewire;

use App\Models\Person;
use App\Traits\CreatePersonTrait;
use App\Traits\WireAlertTrait;
use Livewire\Component;
use Livewire\WithPagination;

class PeopleManager extends Component
{
    use WithPagination, WireAlertTrait, CreatePersonTrait;

    public string $search = "";
    public array $selected_items = [];
    public bool $select_all_current_page = false;

    public function render(): \Illuminate\Contracts\View\View
    {
        // Apply search
        $people = $this->findPeople()->paginate(10);

        // Sync the "select all" checkbox state
        $current_page_ids = $people->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        $this->select_all_current_page = !empty($current_page_ids) &&
            count(array_intersect($this->selected_items, $current_page_ids)) === count($current_page_ids);

        return view('livewire.people-manager', [
            'people' => $people
        ]);
    }

    /*
     * Applies filtering on the People returned to the page
     */
    private function findPeople()
    {
        $query = Person::query();

        // Apply search
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('surname', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('mobile_number', 'like', $searchTerm)
                    ->orWhere('south_african_id', 'like', $searchTerm)
                    ->orWhere('language', 'like', $searchTerm);
            });
        }

        return $query->latest();
    }

    /*
     * Handle the state of the main table checkbox in order to select all entries.
     */
    public function updatedSelectAllCurrentPage(bool $value): void
    {
        // Re-run the query to get IDs for the *current* filtered and paginated view
        $query = $this->findPeople();

        $current_page_ids = $query
            ->paginate(10)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();

        if ($value) {
            // Add all current page IDs to the selected items
            $this->selected_items = $current_page_ids;
        } else {
            // Remove all current page IDs from the selected items
            $this->selected_items = array_diff($this->selected_items, $current_page_ids);
        }
    }

    /**
     * Bulk Action: delete all selected entries.
     */
    public function deleteSelected(): void
    {
        if (empty($this->selected_items)) {
            $this->sendAlert('info', 'No items selected.');
            return;
        }

        $count = count($this->selected_items);
        Person::whereIn('id', $this->selected_items)->delete();

        $this->selected_items = [];
        $this->select_all_current_page = false;

        $this->sendAlert('success', "$count items deleted successfully.");
    }

    /**
     * Sets the component state to edit an existing person.
     *
     * This populates the form properties with the person's data
     * and dispatches an event to show the modal in edit mode.
     */
    public function editPerson(Person $person): void
    {
        $this->name = $person->name;
        $this->surname = $person->surname;
        $this->email = $person->email;
        $this->south_african_id = $person->south_african_id;
        $this->mobile_number = $person->mobile_number;
        $this->birth_date = $person->birth_date;
        $this->language = $person->language;
        $this->interests = $person->interests->pluck('name')->toArray();

        $this->dispatch('updated-input-interests', ['value' => $this->interests]);
        $this->dispatch('updated-input-birth_date', ['value' => $this->birth_date]);
        $this->dispatch('updated-input-mobile_number', ['value' => $this->mobile_number]);

        $this->is_editing = true;
        $this->person_to_edit = $person;

        $this->dispatch('show-create-person-modal');
    }
}
