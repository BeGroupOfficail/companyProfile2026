<?php

use App\Http\Controllers\Dashboard\Destination\DestinationController;
use Illuminate\Support\Facades\Route;



Route::resource('destinations', DestinationController::class);
