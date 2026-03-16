<?php

use App\Http\Controllers\Dashboard\Seo\CompanySeoController;
use Illuminate\Support\Facades\Route;

Route::get('company-seo', [CompanySeoController::class, 'edit'])->name('company-seo.edit');
Route::put('company-seo', [CompanySeoController::class, 'update'])->name('company-seo.update');
