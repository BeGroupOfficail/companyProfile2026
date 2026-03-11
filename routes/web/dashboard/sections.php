<?php

use App\Http\Controllers\Dashboard\Section\SectionController;
use App\Http\Controllers\Dashboard\Section\SubSectionController;
use App\Http\Controllers\Dashboard\Section\SubSectionItemController;
use Illuminate\Support\Facades\Route;


Route::resource('sections', SectionController::class);
Route::resource('sub-sections', SubSectionController::class);
Route::resource('sub-section-items', SubSectionItemController::class);

