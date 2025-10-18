@extends('layouts.app')

@section('content')

    <div id="s_dashboard">
        <!-- Spacing | 2.25 _ 4.5 _ 6 -->
        <div class="pb-9 pb-sm-11 pb-lg-12"></div>

        <!-- People Manager Livewire Component -->
        @livewire('people-manager')

        <!-- Spacing | 6.5 _ 7.5 _ 10 -->
        <div class="pb-12 mb-4 pb-sm-12 mb-sm-8 pb-lg-15 mb-lg-0"></div>
    </div>

@endsection
