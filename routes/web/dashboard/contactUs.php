<?php

use App\Http\Controllers\Dashboard\ContactUsController;
use Illuminate\Support\Facades\Route;

Route::resource('contact-us', ContactUsController::class )->parameters([
    'contact-us' => 'contactUs',
]);
