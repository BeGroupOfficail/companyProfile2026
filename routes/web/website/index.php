<?php

use App\Http\Controllers\Dashboard\Service\ServiceController;
use App\Http\Controllers\WebSite\BlogCategoryController;
use App\Http\Controllers\WebSite\BlogController;
use App\Http\Controllers\WebSite\HomeController;
use Illuminate\Support\Facades\Route;

Route::name('website.')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('home');
  Route::get('/about-us', [HomeController::class, 'about_us'])->name('about_us');
  Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact_us');
  Route::post('/contact-us-save', [HomeController::class, 'contact_us_save'])->name('contact-us-save');

  Route::get('/blogs', [BlogController::class, 'blogs'])->name('blogs');
  Route::get('/blogs/{blog}', [BlogController::class, 'blog'])->name('blog');

  Route::get('/services', [HomeController::class, 'services'])->name('services');
  Route::get('/services/{service}', [HomeController::class, 'service'])->name('service');

  Route::get('/blog-categories/{blogCategory}', [BlogCategoryController::class, 'blog_category'])->name('blog_category');

  Route::get('/pages/{page}', [HomeController::class, 'page'])->name('page');

  Route::get('/destinations', [HomeController::class, 'destinations'])->name('destinations');
  Route::get('/destinations/{destination}', [HomeController::class, 'destination'])->name('destination');

  Route::get('/tours', [HomeController::class, 'tours'])->name('tours');
  Route::get('/tours/{tour}', [HomeController::class, 'tour'])->name('tour');
});
