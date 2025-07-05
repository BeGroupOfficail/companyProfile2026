<?php

use App\Http\Controllers\Dashboard\About\AboutController;
use App\Http\Controllers\Dashboard\About\AboutValueController;
use Illuminate\Support\Facades\Route;

Route::get('edit/about', [AboutController::class,'edit'])->name('about.edit');
Route::patch('update/about', [AboutController::class,'update'])->name('about.update');
Route::resource('about-values', AboutValueController::class);
