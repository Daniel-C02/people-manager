
<div class="container-xxl">
    <div class="d-flex align-items-center justify-content-between pb-8">
        {{-- Page Title --}}
        <h3 class="text-dark-500 mb-0">
            People Management
        </h3>
        {{-- Add New User --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPersonModal">
            Create New Person
        </button>
    </div>

    {{-- Management Table Header Data --}}
    @php
        $tableHeaders = [
            [
                'name' => "Name",
                'unique_value' => "name",
                'sortable' => true,
            ],
            [
                'name' => "Surname",
                'unique_value' => "surname",
                'sortable' => true,
            ],
            [
                'name' => "Email",
                'unique_value' => "email",
                'sortable' => false,
            ],
            [
                'name' => "Mobile Number",
                'unique_value' => "mobile_number",
                'sortable' => false,
            ],
            [
                'name' => "Language",
                'unique_value' => "language",
                'sortable' => false,
            ],
            [
                'name' => "SA ID",
                'unique_value' => "south_african_id",
                'sortable' => false,
            ],
            [
                'name' => "Birth Date",
                'unique_value' => "formatted_birth_date",
                'sortable' => true,
            ],
            [
                'name' => "Interests",
                'unique_value' => "interests",
                'sortable' => false,
            ],
        ];
    @endphp

    <div class="card rounded-2 overflow-hidden">

        {{-- Management Table Form Actions Bar --}}
        <div class="d-flex align-items-center justify-content-between bg-neutral-5 gap-4 py-6 px-8">
            {{-- Bulk Actions --}}
            <div class="dropdown">
                <button
                    class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    @disabled(empty($selected_items))
                >
                    <i class="bi bi-three-dots-vertical"></i>
                    Bulk Actions
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a
                            class="dropdown-item @if(empty($selected_items)) disabled @endif"
                            href="#"
                            wire:click.prevent="deleteSelected"
                            wire:confirm="Are you sure you want to delete these {{ count($selected_items) }} items?"
                        >
                            Delete selected
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Search Bar --}}
            <x-forms.input
                type="text"
                placeholder="Search by name, email, etc..."
                name="search"
            />
        </div>

        {{-- Management Table --}}
        <div class="table-responsive">
            <table class="table table-hover mb-0">

                {{-- Table Header --}}
                <thead class="table-info">
                <tr>
                    {{-- Checkbox Header --}}
                    <th scope="col">
                        {{-- This checkbox is to select/deselect all --}}
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="selectAllCheckbox"
                            wire:model.live="select_all_current_page"
                        >
                    </th>

                    {{-- Dynamic Headers from $tableHeaders --}}
                    @foreach ($tableHeaders as $header)
                        <th scope="col">
                            {{ $header['name'] }}

                            {{-- Sorting logic/icons --}}
                            @if ($header['sortable'])

                            @endif
                        </th>
                    @endforeach
                    {{-- Actions columns --}}
                    <th scope="col"></th> {{-- View & Edit --}}
                </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="table-neutral">
                {{-- Loop through your data collection. --}}
                @forelse ($people as $person)
                    <tr>
                        {{-- Checkbox Body Cell --}}
                        <td>
                            {{-- "selected_items[]" allows multiple IDs to be stored as an array --}}
                            <input
                                class="form-check-input"
                                type="checkbox"
                                wire:model.live="selected_items"
                                value="{{ $person->id }}"
                            >
                        </td>

                        {{-- Dynamic Data Cells --}}
                        @foreach ($tableHeaders as $header)
                            <td>
                                @if ($header['unique_value'] === 'interests')
                                    {{-- Loop through interests and display as pills --}}
                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach($person->interests as $interest)
                                            <div class="border border-secondary-5 rounded-pill px-3 py-1s fs-12">
                                                {{ $interest->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($header['unique_value'] === 'formatted_birth_date')
                                    <span class="text-nowrap">{{ $person->{$header['unique_value']} }}</span>
                                @else
                                    {{-- Access the object property dynamically using the 'unique_value' from our header array. --}}
                                    {{ $person->{$header['unique_value']} }}
                                @endif
                            </td>
                        @endforeach

                        {{-- Row Actions --}}
                        <td>
                            <button
                                href="#"
                                class="btn btn-sm btn-icon"
                                wire:click.prevent="editPerson('{{ $person->id }}')"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    {{-- This row displays if the $users collection is empty --}}
                    <tr>
                        <td colspan="{{ count($tableHeaders) + 2 }}" class="text-center">
                            No records found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Management Table Pgination --}}
        <div class="bg-neutral-5">
            <div class="d-flex align-items-center justify-content-end gap-8 py-6 pe-8">
                {{-- livewire pagination page count --}}
                {{ $people->links('vendor.livewire.bootstrap', ['pageCount' => true]) }}
                {{-- livewire paginatoin page toggles --}}
                {{ $people->links('vendor.livewire.bootstrap', ['toggles' => true]) }}
            </div>
        </div>
    </div>

    {{-- Create Person Modal --}}
    <x-modals.dashboard.create-person
        id="createPersonModal"
        modalSize="modal-lg"
        :isEditing="$is_editing"
    />
</div>

