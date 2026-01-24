<?php

use App\Http\Controllers\BotManController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// index and general  routes
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {
        require base_path('routes/web/website/index.php');
    });

// Authentication routes
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {
        require base_path('routes/web/auth/auth.php');
    });

// Dashboard routes (protected by auth middleware)
Route::prefix(LaravelLocalization::setLocale() . '/dashboard')
    ->middleware(['auth-admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {
        require base_path('routes/web/dashboard/index.php');
        require base_path('routes/web/dashboard/settings.php');
        require base_path('routes/web/dashboard/user.php');
        require base_path('routes/web/dashboard/albums.php');
        require base_path('routes/web/dashboard/clients.php');
        require base_path('routes/web/dashboard/menus.php');
        require base_path('routes/web/dashboard/pages.php');
        require base_path('routes/web/dashboard/sliders.php');
        require base_path('routes/web/dashboard/blogs.php');
        require base_path('routes/web/dashboard/services.php');
        require base_path('routes/web/dashboard/testimonials.php');
        require base_path('routes/web/dashboard/about.php');
        require base_path('routes/web/dashboard/contactUs.php');
        require base_path('routes/web/dashboard/websiteStatistics.php');
        require base_path('routes/web/dashboard/projects.php');
    });

