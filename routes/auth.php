<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Group routes that should only be accessible to 'guest' users (not logged in)
Route::middleware('guest')->group(function () {

    // GET route for the login page
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
});

// Group routes that should only be accessible to 'auth' users (logged in)
Route::middleware('auth')->group(function () {

    // POST route for logging out
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
