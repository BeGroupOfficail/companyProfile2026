<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Route;


// User Login & Register routes
Route::get('/register', [RegisterController::class,'showUserRegistration'])->name('register');
Route::get('/login', [LoginController::class, 'showUserLogin'])->name('login');

// Admin Login & Register routes
Route::prefix('dashboard')->group(function () {
    Route::get('/register', [RegisterController::class, 'showAdminRegistration'])->name('admin.register');
    Route::get('/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');
});

Route::post('/register', [RegisterController::class,'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Forgot Password Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset Password Routes
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Google Login//
Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

// Facebook Login//
Route::get('/auth/facebook', [SocialLoginController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('/auth/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback']);
