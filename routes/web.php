<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Define the main route for the application
Route::get('/', function () {
    return view('pages.dashboard');
})
    // 'auth': The user must be logged in to see this page.
    ->middleware(['auth', 'verified'])
    // Assign a name to this route, so we can link to it easily in our app.
    ->name('dashboard');

// Include all the authentication-related routes (login, register, logout, etc.).
require __DIR__.'/auth.php';
