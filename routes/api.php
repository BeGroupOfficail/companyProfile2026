<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    HomeController,
    AboutController,
    ServiceController,
    ProjectController,
    ContactController,
    SocialLinkController
};


Route::prefix('{lang}')
    ->whereIn('lang', ['en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {

        // Home
        Route::get('/home', [HomeController::class, 'index']);

        // About
        Route::get('/about', [AboutController::class, 'index']);

        // Services
        Route::get('/services', [ServiceController::class, 'index']);

        // Projects
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::get('/projects/{project}', [ProjectController::class, 'show']);

        // Contact info
        Route::get('/contact-info', [ContactController::class, 'info']);
    });


Route::post('/contact-message', [ContactController::class, 'store'])
    ->middleware('throttle:10,1');


Route::get('/social-links', [SocialLinkController::class, 'index']);
