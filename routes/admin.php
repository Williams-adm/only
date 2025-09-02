<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ShippingCompanyController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('admin.dashboard');
})->middleware('can:access dashboard')->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/options', [OptionController::class, 'index'])->name('options.index');

Route::resource('brands', BrandController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubCategoryController::class);
Route::resource('products', ProductController::class);

Route::get('/products/{product}/variants', [VariantController::class, 'create'])
    ->name('variants.create')
    ->scopeBindings();
Route::get('/products/{product}/variants/{variant}', [VariantController::class, 'edit'])
    ->name('variants.edit')
    ->scopeBindings();
Route::match(['put', 'patch'], '/products/{product}/variants/{variant}', [VariantController::class, 'update'])
    ->name('variants.update')
    ->scopeBindings();

Route::resource('covers', CoverController::class);

Route::resource('shipping-companies', ShippingCompanyController::class);
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
