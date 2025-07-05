<?php

use App\Http\Controllers\Dashboard\Menu\MenuController;
use App\Http\Controllers\Dashboard\Menu\MenuItemController;
use Illuminate\Support\Facades\Route;


Route::resource('menus', MenuController::class);
Route::resource('menu-items', MenuItemController::class);
Route::post('menu-items/type-values', [MenuItemController::class,'getMenuTypeValues'])->name('menu-type-values');




