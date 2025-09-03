<?php

use App\Http\Controllers\Api\Movil\BrandController;
use App\Http\Controllers\Api\Movil\CategoryController;
use App\Http\Controllers\Api\Movil\ProductController;
use App\Http\Controllers\Api\Movil\UserController;
use App\Http\Controllers\Api\SortController;
use Illuminate\Support\Facades\Route;

Route::post('/sort/covers', [SortController::class, 'orderCover'])->name('api.sort.orderCover');

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('categories', [CategoryController::class, 'getAll']);
    Route::get('brands', [BrandController::class, 'getAll']);
    Route::get('products', [ProductController::class, 'getAll']);
    Route::get('products/scan/{code}', [ProductController::class, 'scanBarcode']);
    Route::get('products/{product}', [ProductController::class, 'getById']);
});
