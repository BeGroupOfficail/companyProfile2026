<?php

use App\Http\Controllers\WebSite\HomeController;
use Illuminate\Support\Facades\Route;

Route::name('website.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/about-us', [HomeController::class, 'about_us'])->name('about_us');

    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact_us');
    Route::post('/contact-us-save', [HomeController::class, 'contact_us_save'])->name('contact-us-save');

    Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');

    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/services/{service}', [HomeController::class, 'serviceDetails'])->name('service-details');

    Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
    Route::get('/projects/{project}', [HomeController::class, 'projectDetails'])->name('project-details');


    Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('/blogs/{blog}', [HomeController::class, 'blogDetails'])->name('blog');

    Route::get('/blog-categories/{blogCategory}', [BlogCategoryController::class, 'blog_category'])->name('blog_category');

    Route::get('/pages/{page}', [HomeController::class, 'pageDetails'])->name('page-details');

    Route::get('/clients', [HomeController::class, 'clients'])->name('clients');

});
