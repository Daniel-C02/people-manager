@props([
    'id' => "",
    'modalSize' => "",
])

{{-- Bootstrap modal wrapper | Sets the base config for modals created on this project --}}
<div
    id="{{ $id }}"
    @class(['modal fade', $modalSize])
    tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false"
    wire:ignore.self
>
    {{ $slot }}
</div>
