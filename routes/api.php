<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;


Route::prefix('{lang}')
    ->whereIn('lang', ['en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {

        // Home
        Route::get('/home', [HomeController::class, 'index']);

    });


Route::post('/contact-message', [ContactController::class, 'store'])
    ->middleware('throttle:10,1');



