<?php

use App\Http\Controllers\dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});