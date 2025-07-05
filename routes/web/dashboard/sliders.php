<?php

use App\Http\Controllers\Dashboard\Slider\SliderController;
use Illuminate\Support\Facades\Route;



Route::resource('sliders', SliderController::class);

