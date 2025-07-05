<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('{modelname}/change-status/{ids}',[DashboardController::class ,'changeStatus'])->name('change.status');
Route::get('/',[DashboardController::class ,'home'])->name('dashboard.home');


Route::resource('messages',MessageController::class);
Route::post('messages',[MessageController::class,'sendMessage'])->name('messages.send');

