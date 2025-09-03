<?php

use App\Http\Controllers\Api\Movil\BrandController;
use App\Http\Controllers\Api\movil\CartController;
use App\Http\Controllers\Api\Movil\CategoryController;
use App\Http\Controllers\Api\Movil\ProductController;
use App\Http\Controllers\Api\Movil\SaleController;
use App\Http\Controllers\Api\Movil\UserController;
use App\Http\Controllers\Api\SortController;
use Illuminate\Support\Facades\Route;

Route::post('/sort/covers', [SortController::class, 'orderCover'])->name('api.sort.orderCover');

Route::prefix('v1')->group( function () {
    Route::post('login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('logout', [UserController::class, 'logout']);
        Route::get('categories', [CategoryController::class, 'getAll']);
        Route::get('brands', [BrandController::class, 'getAll']);
        Route::get('products', [ProductController::class, 'getAll']);
        Route::get('products/scan/{code}', [ProductController::class, 'scanBarcode']);
        Route::get('products/{product}', [ProductController::class, 'getById']);

        Route::get('salessummary/content', [CartController::class, 'contentSummary']);
        Route::put('salessummary/update/{rowID}', [CartController::class, 'updateSummary']);
        Route::post('salessummary/add', [CartController::class, 'addSummary']);
        Route::delete('salessummary/destroy', [CartController::class, 'destroySummary']);
        Route::delete('salessummary/remove/{rowID}', [CartController::class, 'removeSummary']);

        Route::post('sales/complete', [SaleController::class, 'completeSale']);
        Route::get('sales', [SaleController::class, 'getAll']);
        Route::get('sales/{id}', [SaleController::class, 'getByID']);
    });
});
