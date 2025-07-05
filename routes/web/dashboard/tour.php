<?php

use App\Http\Controllers\Dashboard\Tour\TourController;
use Illuminate\Support\Facades\Route;



Route::resource('tours', TourController::class);
