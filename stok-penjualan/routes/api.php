<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::apiResource('products', ProductController::class);
Route::get('products/low-stock/list', [ProductController::class, 'lowStock']);
Route::get('products/categories/list', [ProductController::class, 'categories']);

Route::apiResource('sales', SaleController::class);