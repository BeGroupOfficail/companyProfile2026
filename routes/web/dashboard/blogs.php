<?php

use App\Http\Controllers\Dashboard\Blog\BlogController;
use App\Http\Controllers\Dashboard\BlogCategory\BlogCategoryController;
use Illuminate\Support\Facades\Route;



Route::resource('blogs', BlogController::class);
Route::resource('blog-categories', BlogCategoryController::class);

Route::delete('/destroy-blog-faqs', [BlogController::class, 'blogFaqDestroy'])->name('blog-faqs.destroy');

