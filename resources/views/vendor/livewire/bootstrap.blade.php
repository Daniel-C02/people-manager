@props(['indexes' => false, 'toggles' => false, 'pageCount' => false])

@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div class="my-pagination">

    {{-- pagination indexes --}}
    @if($indexes)
        <div class="d-flex gap-1 align-items-center text-neutral-1 flex-none fs-14">
            {!! __('Showing') !!}
            <span class="d-flex flex-column gap-1s bg-neutral-5 rounded-2 mx-1s" style="padding: 6px 10px;">
                {{ $paginator->firstItem() ? $paginator->firstItem() : 0 }}
                {!! __('to') !!}
                {{ $paginator->lastItem() ? $paginator->lastItem() : 0 }}
            </span>
            {!! __('of') !!}
            <span class="">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </div>
    @endif

    {{-- pagination page count | "from 'x' pages" --}}
    @if($pageCount && $paginator->lastPage() > 1)
        <div class="pageCount d-flex gap-1 align-items-center">
            <span>From</span>
            <span>{{ $paginator->lastPage() }}</span>
            <span>pages</span>
        </div>
    @endif

    {{-- pagination page toggles --}}
    @if($toggles && $paginator->hasPages())
        <ul class="pagination justify-content-end mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <img src="/img/pagination/arrow-left-disabled.svg" alt="arrow left">
                    </span>
                </li>
            @else
                <li class="page-item">
                    <button
                        type="button"
                        class="page-link"
                        dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        aria-label="@lang('pagination.previous')"
                    >
                        <img class="active-arrow" src="/img/pagination/arrow-left.svg" alt="arrow left">
                        <img class="disabled-arrow" src="/img/pagination/arrow-left-disabled.svg" alt="arrow left">
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"
                                wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                aria-current="page"
                            >
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button
                        type="button"
                        dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="page-link"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        aria-label="@lang('pagination.next')"
                    >
                        <img class="active-arrow" src="/img/pagination/arrow-right.svg" alt="arrow left">
                        <img class="disabled-arrow" src="/img/pagination/arrow-right-disabled.svg" alt="arrow left">
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <img class="active-arrow" src="/img/pagination/arrow-right.svg" alt="arrow left">
                        <img class="disabled-arrow" src="/img/pagination/arrow-right-disabled.svg" alt="arrow left">
                    </span>
                </li>
            @endif
        </ul>
    @endif
</div>


{{--@php--}}
{{--if (! isset($scrollTo)) {--}}
{{--    $scrollTo = 'body';--}}
{{--}--}}

{{--$scrollIntoViewJsSnippet = ($scrollTo !== false)--}}
{{--    ? <<<JS--}}
{{--       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()--}}
{{--    JS--}}
{{--    : '';--}}
{{--@endphp--}}

{{--<div>--}}
{{--    @if ($paginator->hasPages())--}}
{{--        <nav class="d-flex justify-items-center justify-content-between">--}}
{{--            <div class="d-flex justify-content-between flex-fill d-sm-none">--}}
{{--                <ul class="pagination">--}}
{{--                    --}}{{-- Previous Page Link --}}
{{--                    @if ($paginator->onFirstPage())--}}
{{--                        <li class="page-item disabled" aria-disabled="true">--}}
{{--                            <span class="page-link">@lang('pagination.previous')</span>--}}
{{--                        </li>--}}
{{--                    @else--}}
{{--                        <li class="page-item">--}}
{{--                            <button type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">@lang('pagination.previous')</button>--}}
{{--                        </li>--}}
{{--                    @endif--}}

{{--                    --}}{{-- Next Page Link --}}
{{--                    @if ($paginator->hasMorePages())--}}
{{--                        <li class="page-item">--}}
{{--                            <button type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">@lang('pagination.next')</button>--}}
{{--                        </li>--}}
{{--                    @else--}}
{{--                        <li class="page-item disabled" aria-disabled="true">--}}
{{--                            <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">--}}
{{--                <div>--}}
{{--                    <p class="small text-muted">--}}
{{--                        {!! __('Showing') !!}--}}
{{--                        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>--}}
{{--                        {!! __('to') !!}--}}
{{--                        <span class="fw-semibold">{{ $paginator->lastItem() }}</span>--}}
{{--                        {!! __('of') !!}--}}
{{--                        <span class="fw-semibold">{{ $paginator->total() }}</span>--}}
{{--                        {!! __('results') !!}--}}
{{--                    </p>--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <ul class="pagination">--}}
{{--                        --}}{{-- Previous Page Link --}}
{{--                        @if ($paginator->onFirstPage())--}}
{{--                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
{{--                                <span class="page-link" aria-hidden="true">&lsaquo;</span>--}}
{{--                            </li>--}}
{{--                        @else--}}
{{--                            <li class="page-item">--}}
{{--                                <button type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.previous')">&lsaquo;</button>--}}
{{--                            </li>--}}
{{--                        @endif--}}

{{--                        --}}{{-- Pagination Elements --}}
{{--                        @foreach ($elements as $element)--}}
{{--                            --}}{{-- "Three Dots" Separator --}}
{{--                            @if (is_string($element))--}}
{{--                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>--}}
{{--                            @endif--}}

{{--                            --}}{{-- Array Of Links --}}
{{--                            @if (is_array($element))--}}
{{--                                @foreach ($element as $page => $url)--}}
{{--                                    @if ($page == $paginator->currentPage())--}}
{{--                                        <li class="page-item active" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>--}}
{{--                                    @else--}}
{{--                                        <li class="page-item" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $page }}</button></li>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                        --}}{{-- Next Page Link --}}
{{--                        @if ($paginator->hasMorePages())--}}
{{--                            <li class="page-item">--}}
{{--                                <button type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.next')">&rsaquo;</button>--}}
{{--                            </li>--}}
{{--                        @else--}}
{{--                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
{{--                                <span class="page-link" aria-hidden="true">&rsaquo;</span>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </nav>--}}
{{--    @endif--}}
{{--</div>--}}
