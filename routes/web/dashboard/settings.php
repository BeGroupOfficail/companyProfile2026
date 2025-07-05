<?php

use App\Http\Controllers\Dashboard\AreaController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use Illuminate\Support\Facades\Route;


Route::prefix('settings')->name('settings.')->group(function () {

    Route::resource('countries', CountryController::class);
    Route::resource('regions', RegionController::class);
    Route::get('getCountryRegions',[AreaController::class, 'getCountryRegions'])->name('getCountryRegions');
    Route::get('getRegionAreas',[AreaController::class, 'getRegionAreas'])->name('getRegionAreas');
    Route::resource('areas', AreaController::class);
    Route::resource('general-settings', SettingController::class)->only(['edit', 'update']);

    Route::get('website-designs',[SettingController::class, 'getWebsiteDesign'])->name('website-designs');
    Route::post('update-website-designs',[SettingController::class, 'updateWebsiteDesign'])->name('update-website-designs');
    Route::post('update-section-order',[SettingController::class, 'updateSectionOrder'])->name('update-section-order');
});
