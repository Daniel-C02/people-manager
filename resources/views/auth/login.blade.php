@extends('layouts.app', ['showNavbar' => false, 'showFooter' => false])

@section('content')

    <div class="container-xxl">

        <!-- Spacing | 2.25 _ 6 _ 8 -->
        <div class="pb-9 pb-sm-12 pb-lg-14"></div>

        {{-- Center the login card --}}
        <div class="row justify-content-center align-items-center">
            <div class="col-md-84 col-lg-60 col-xl-48">
                {{-- Use the same card and padding structure as your modals/cards --}}
                <div class="card rounded-2 shadow-sm">
                    <form method="POST" action="{{ route('login') }}" class="p-8">
                        @csrf

                        {{-- Page Title --}}
                        <h3 class="pb-6">
                            <span class="text-primary-5">Log</span>
                            <span class="text-secondary-5">In</span>
                        </h3>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        {{-- Form Elements --}}
                        <div class="d-flex flex-column gap-6">

                            <x-forms.standard-input
                                type="email"
                                name="email"
                                label="Email Address"
                                placeholder="Email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-100"
                            />

                            <x-forms.standard-input
                                type="password"
                                name="password"
                                label="Password"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                                class="w-100"
                            />

                            {{-- Remember me checkbox --}}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                        </div>

                        {{-- Action buttons --}}
                        <div class="d-flex gap-6 pt-8 mt-6">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Spacing | 6.5 _ 7.5 _ 10 -->
        <div class="pb-12 mb-4 pb-sm-12 mb-sm-8 pb-lg-15 mb-lg-0"></div>
    </div>

@endsection
