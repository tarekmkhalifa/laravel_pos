<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\Client\OrderController;
use App\Http\Controllers\dashboard\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\UserController;

Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    // Category routes
    Route::resource('categories', CategoryController::class)->except('show');
    // Product routes
    Route::resource('products', ProductController::class)->except('show');
    // Clients routes
    Route::resource('clients', ClientController::class)->except('show');
    Route::resource('clients.orders', OrderController::class)->except('show');
    
    // Order routes
    Route::resource('orders', DashboardOrderController::class);
    Route::get('orders/{order}/products', [DashboardOrderController::class, 'products'])->name('orders.products');

    // User(admin) routes
    Route::resource('users', UserController::class)->except('show');
});