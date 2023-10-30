<?php

use App\Http\Controllers\Apps\CartController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\VendorController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\CustomerController;
use App\Http\Controllers\Apps\DetailProductController;
use App\Http\Controllers\Apps\HomeController;
use App\Http\Controllers\Apps\PermissionController;
use App\Models\DetailProduct;

Route::get('/', [HomeController::class, 'index']);

Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('cart-detail', [CartController::class, 'cartDetail'])->name('cartDetail');
Route::post('cart-update', [CartController::class, 'updateCart'])->name('updateCart');

Route::group(['middleware' => ['auth'], 'prefix' => 'app', 'as' => 'app.'], function () {
    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('pages.app.dashboard');
    })->name('home');

    // Permission Route
    Route::get('/permissions', PermissionController::class)
        ->name('permissions')->middleware('permission:permissions.index');

    // Roles Route
    Route::resource('/roles', RoleController::class)->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

    //Users Route
    Route::resource('/users', UserController::class)->middleware('permission:users.index|users.create|users.edit|users.delete');

    //Categories Route
    Route::resource('/categories', CategoryController::class)->middleware('permission:categories.index|categories.create|categories.edit|categories.delete');

    //Categories Status Route
    Route::put('category/change-status', [CategoryController::class, 'changeStatus'])->name('categories.change-status');

    //Vendors Route
    Route::resource('/vendors', VendorController::class)->middleware('permission:vendors.index|vendors.create|vendor.edit|vendors.delete');

    //Vendors Status Route
    Route::put('vendor/change-status', [VendorController::class, 'changeStatus'])->name('vendors.change-status');

    //Products Route
    Route::resource('/products', ProductController::class)->middleware('permission:products.index|products.create|products.edit|products.delete');

    //Details Product Route
    Route::resource('/detail-products', DetailProductController::class);

    //Customer's Route
    Route::resource('/customers', CustomerController::class);
});
