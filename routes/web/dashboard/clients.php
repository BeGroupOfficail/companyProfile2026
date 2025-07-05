<?php

use App\Http\Controllers\Dashboard\Client\ClientController;
use Illuminate\Support\Facades\Route;



Route::resource('clients', ClientController::class);
