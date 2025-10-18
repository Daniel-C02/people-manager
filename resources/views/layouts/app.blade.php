@props(['showNavbar' => true, 'showFooter' => true])

<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Title -->
    <title>{{ config('app.name', 'People Manager') }}</title>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Vite Imports -->
    @vite(['resources/js/app.js'])

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Livewire Styles -->
    @livewireStyles

</head>

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->

<body>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Navbar -->
    @if($showNavbar)
        @include('partials.navbar')
    @endif

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Footer -->
    @if($showFooter)
        @include('partials.footer')
    @endif

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Livewire Scripts | AlpineJs is Included -->
    @livewireScripts

</body>
</html>
