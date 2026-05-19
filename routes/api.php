<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'summary']);
Route::delete('/dashboard/cache', [DashboardController::class, 'flushCache']);

Route::get('/users/{user}/orders/{order}', [OrderController::class, 'showForUser'])
    ->scopeBindings();
