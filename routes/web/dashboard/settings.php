<?php
use App\Http\Controllers\Dashboard\Setting\SettingController;
use Illuminate\Support\Facades\Route;


Route::prefix('settings')->name('settings.')->group(function () {
    Route::resource('general-settings', SettingController::class)->only(['edit', 'update']);
    Route::get('home-sections',[SettingController::class, 'getHomeSections'])->name('home-sections');
    Route::post('update-section-order',[SettingController::class, 'updateSectionOrder'])->name('update-section-order');
});
