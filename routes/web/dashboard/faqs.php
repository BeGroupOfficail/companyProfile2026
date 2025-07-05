<?php

use App\Http\Controllers\Dashboard\Faq\FaqController;
use Illuminate\Support\Facades\Route;



Route::get('faqs', [FaqController::class,'index'])->name('faqs.index');
Route::patch('faqs-update', [FaqController::class,'update'])->name('faqs.update');
