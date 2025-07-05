<?php

use App\Http\Controllers\Dashboard\Album\AlbumController;
use App\Http\Controllers\Dashboard\Album\AlbumImageController;
use App\Http\Controllers\Dashboard\Album\AlbumVideoController;
use Illuminate\Support\Facades\Route;

Route::resource('albums', AlbumController::class);
Route::post('albums/type-values', [AlbumController::class,'getAlbumTypeValues'])->name('albums-type-value');


/// album images routes///
Route::get('albums/album-images/edit/{id}', [AlbumImageController::class,'edit'])->name('albums.album-images.edit');
Route::post('albums/album-images/store/{id}', [AlbumImageController::class,'store'])->name('albums.album-images.store');
Route::post('albums/album-images/upload-images', [AlbumImageController::class,'uploadImages'])->name('albums.album-images.upload');
Route::post('albums/album-images/remove-images', [AlbumImageController::class,'removeUploadImages'])->name('albums.album-images.remove');
Route::post('albums/album-images/{id}/update-order', [AlbumImageController::class, 'updateOrder'])->name('albums.album-images.update-order');
Route::delete('albums/album-images/destroy/{id}', [AlbumImageController::class,'destroy'])->name('albums.album-images.destroy');
Route::post('albums/album-images/change-status/{id}', [AlbumImageController::class,'changeStatus'])->name('albums.album-images.change-status');
/// album videos routes///
Route::get('albums/album-videos/edit/{id}', [AlbumVideoController::class,'edit'])->name('albums.album-videos.edit');
Route::post('albums/album-videos/store/{id}', [AlbumVideoController::class,'store'])->name('albums.album-videos.store');
Route::delete('albums/album-videos/destroy/{id}', [AlbumVideoController::class,'destroy'])->name('albums.album-videos.destroy');
Route::post('albums/album-videos/{id}/update-order', [AlbumVideoController::class, 'updateOrder'])->name('albums.album-videos.update-order');
Route::post('albums/album-videos/change-status/{id}', [AlbumVideoController::class,'changeStatus'])->name('albums.album-videos.change-status');
