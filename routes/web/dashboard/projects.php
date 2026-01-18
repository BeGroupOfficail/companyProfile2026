<?php

use App\Http\Controllers\Dashboard\Project\ProjectController;
use Illuminate\Support\Facades\Route;

Route::resource('projects', ProjectController::class);
