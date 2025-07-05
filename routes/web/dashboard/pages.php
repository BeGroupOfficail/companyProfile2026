<?php

use App\Http\Controllers\Dashboard\Page\PageController;
use Illuminate\Support\Facades\Route;



Route::resource('pages', PageController::class);

