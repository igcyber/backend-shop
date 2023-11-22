<?php

use App\Models\Order;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;
use App\Http\Controllers\Apps\AuthController;
use App\Http\Controllers\Apps\CartController;
use App\Http\Controllers\Apps\HomeController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\OrderController;
use App\Http\Controllers\Apps\SalesController;
use App\Http\Controllers\Apps\VendorController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\CheckOutController;
use App\Http\Controllers\Apps\CustomerController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\CustomerLoginController;
use App\Http\Controllers\Apps\DetailProductController;
use App\Models\Product;

Route::get('/', [HomeController::class, 'index'])->name('front.home');


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
    Route::resource('/detail-products', DetailProductController::class)->middleware('permission:detail_product.index|detail_product.create|detail_product.edit|detail_product.delete');

    //Customer's Route
    Route::resource('/customers', CustomerController::class);

    // add cart
    Route::get('/cart/{detail}/{user}', [CartController::class, 'addCart'])->name('cart.add');
    //get cart
    Route::get('/carts/{user}', [CartController::class, 'getCart'])->name('cart.get');
    //update cart
    Route::post('/carts/update/{user}', [CartController::class, 'updateCart'])->name('cart.update');
    //delete cart
    Route::delete('/cart/delete/{cart}/{user}', [CartController::class, 'deleteCart'])->name('cart.delete');

    //checkout & order
    Route::get('/checkout/order/{user}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order/{user}', [OrderController::class, 'order'])->name('order');

    //get order for sales
    Route::get('/sales/order', [SalesController::class, 'index'])->name('sales');
    //confirmation order
    Route::get('/sales/order/{type}/{order}', [SalesController::class, 'confirmation'])->name('order.confirmation');
    //update order
    Route::post('/sales/update/{order}', [SalesController::class, 'updateOrder'])->name('order.update');
    //delete order
    Route::delete('/sales/delete/{order}', [SalesController::class, 'delete'])->name('order.delete');
});
