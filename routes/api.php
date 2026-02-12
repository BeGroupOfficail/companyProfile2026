<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CountryController;


Route::prefix('{lang}')
    ->whereIn('lang', ['en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {

        // Home
        Route::get('/home', [HomeController::class, 'index']);

        // Countries
        Route::get('/countries', [CountryController::class, 'index']);

    });


Route::post('/contact-message', [ContactController::class, 'store'])
    ->middleware('throttle:10,1');



