@props([
    'id' => "",
    'modalSize' => "",
])

<div
    id="{{ $id }}"
    @class(['modal fade', $modalSize])
    tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false"
    wire:ignore.self
>
    {{ $slot }}
</div>
