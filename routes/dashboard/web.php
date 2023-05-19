<?php

use App\Http\Controllers\dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\UserController;

Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    // Category routes
    Route::resource('categories', CategoryController::class)->except('show');
    // Product routes
    Route::resource('products', ProductController::class)->except('show');
    // User(admin) routes
    Route::resource('users', UserController::class)->except('show');
});