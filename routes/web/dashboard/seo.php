<?php

use App\Http\Controllers\Dashboard\Seo\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('seo/edit/{pageType}', [SeoController::class,'edit'])->name('seo.edit');
Route::patch('update/seo/{pageType}', [SeoController::class,'update'])->name('seo.update');
