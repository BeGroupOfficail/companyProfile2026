<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Redirect /login to /dashboard/login
Route::redirect('/login', '/dashboard/login', 301);

// Admin Login & Register routes
Route::prefix('dashboard')->group(function () {
    Route::get('/login', [LoginController::class, 'showAdminLogin'])->name('dashboard.login');
    Route::post('/login', [LoginController::class, 'login'])->name('dashboard.login.post'); // Add this
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
