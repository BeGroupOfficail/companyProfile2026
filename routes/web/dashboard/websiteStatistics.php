<?php

use App\Http\Controllers\Dashboard\WebsiteStatistics\WebsiteStatisticsController;
use Illuminate\Support\Facades\Route;



Route::resource('website-statistics', WebsiteStatisticsController::class);
