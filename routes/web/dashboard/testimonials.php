<?php

use App\Http\Controllers\Dashboard\Testimonial\TestimonialController;
use Illuminate\Support\Facades\Route;



Route::resource('testimonials', TestimonialController::class);
