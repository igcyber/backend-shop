<?php

use App\Models\Order;
use App\Models\Product;
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
use App\Http\Controllers\Apps\InvoiceController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\CheckOutController;
use App\Http\Controllers\Apps\CustomerController;
use App\Http\Controllers\Apps\FlashSaleController;
use App\Http\Controllers\Apps\AdminSalesController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\CustomerLoginController;
use App\Http\Controllers\Apps\DetailProductController;
use App\Http\Controllers\Apps\MarkedProductController;

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
    //Users import Route
    Route::post('/users/import-excel', [UserController::class, 'importExcel'])->name('users.import.excel');


    //Categories Route
    Route::resource('/categories', CategoryController::class)->middleware('permission:categories.index|categories.create|categories.edit|categories.delete');
    //Categories Status Route
    Route::put('category/change-status', [CategoryController::class, 'changeStatus'])->name('categories.change-status');
    //Categories Import Route
    Route::post('/categories/import-excel', [CategoryController::class, 'importExcel'])->name('categories.import.excel');


    //Vendors Route
    Route::resource('/vendors', VendorController::class)->middleware('permission:vendors.index|vendors.create|vendor.edit|vendors.delete');
    //Vendors Status Route
    Route::put('vendor/change-status', [VendorController::class, 'changeStatus'])->name('vendors.change-status');
    //Vendors Import Route
    Route::post('/vendors/import-excel', [VendorController::class, 'importExcel'])->name('vendors.import.excel');

    //Products Route
    Route::resource('/products', ProductController::class)->middleware('permission:products.index|products.create|products.edit|products.delete');
    //products import via excel
    Route::post('/products/import-excel', [ProductController::class, 'importExcel'])->name('products.import.excel');
    //products export via excel
    Route::get('/export-orders', [ProductController::class, 'exportToExcel'])->name('products.export');

    //Details Product Route
    Route::resource('/detail-products', DetailProductController::class)->middleware('permission:detail_product.index|detail_product.create|detail_product.edit|detail_product.delete');
    // routes import for detail product
    Route::post('/detail-products/import', [DetailProductController::class, 'importExcel'])->name('detail-products.import');
    // routes update sales for detail product
    Route::put('/update-sales/product/{detailId}', [DetailProductController::class, 'updateSalesProduct'])->name('product.updateSales');

    //Customer's Route
    Route::resource('/customers', CustomerController::class);
    // routes import
    Route::post('/customers/import', [CustomerController::class, 'importExcel'])->name('customer.import');
    // routes update sales
    Route::put('/update-sales/{customerId}', [CustomerController::class, 'updateSales'])->name('customer.updateSales');


    // add cart
    Route::get('/cart/{detail}/{user}', [CartController::class, 'addCart'])->name('cart.add');
    //get cart
    Route::get('/carts/{user}', [CartController::class, 'getCart'])->name('cart.get');
    //update cart
    Route::post('/carts/update/{user}', [CartController::class, 'updateCart'])->name('cart.update');
    //delete cart
    Route::delete('/cart/delete/{cart}/{user}', [CartController::class, 'deleteCart'])->name('cart.delete');

    Route::get('/mark-product/{detailId}/{user}', [MarkedProductController::class, 'markProduct'])->name('markProduct');


    Route::get('/marked-products', [MarkedProductController::class, 'getMarkedProducts']);

    //checkout & order
    Route::get('/checkout/order/{user}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order/{user}', [OrderController::class, 'order'])->name('order');

    //get all new order for sales
    Route::get('/sales/all-order', [SalesController::class, 'allOrder'])->name('allOrder');
    //get process order for sales
    Route::get('/sales/order', [SalesController::class, 'index'])->name('sales');
    //POS sales
    Route::get('/sales/order/pos/', [SalesController::class, 'order'])->name('sales.order');
    //sales add cart
    Route::get('/sales/order/{detail}/{sales}', [SalesController::class, 'addCart'])->name('sales.cart');
    //update sales cart
    Route::post('/sales/order/update/{sales}', [SalesController::class, 'createOrder'])->name('sales.cart.update');
    //sales delete cart
    Route::delete('/sales/delete/{id}', [SalesController::class, 'deleteCart'])->name('sales.delete');
    //sales process order
    Route::get('/sales/process-order/{userId}', [SalesController::class, 'processOrder'])->name('sales.process-order');


    //confirmation order
    Route::get('/confirmation/{type}/{order}', [SalesController::class, 'confirmation'])->name('confirmation');
    //update order
    Route::post('/sales/update/{order}', [SalesController::class, 'updateOrder'])->name('order.update');
    //delete order
    Route::delete('/sales/delete/{order}', [SalesController::class, 'delete'])->name('order.delete');

    //edit order_details
    Route::get('/sales/edit-order-detail/{orderId}', [SalesController::class, 'editOrderDetail'])->name('sales.editOrderDetail');

    //update order details
    Route::put('/sales/update-order-detail/{orderId}', [SalesController::class, 'updateOrderDetail'])->name('sales.updateOrderDetail');

    Route::post('/update-total-amount/{order}', [OrderController::class, 'updateTotalAmount'])->name('update.total_amount');

    //Flash Sale Route
    Route::get('/sales/flash', [FlashSaleController::class, 'index'])->name('flash.sales');
    Route::put('/sales/flash/update', [FlashSaleController::class, 'update'])->name('flash.sales.update');
    Route::put('/sales/add-product', [FlashSaleController::class, 'addProduct'])->name('flash.sales.addProduct');
    Route::put('/sales/change-status', [FlashSaleController::class, 'changeStatus'])->name('change.status');


    // Admin Sales Route
    Route::get('/admin-sales', [AdminSalesController::class, 'index'])->name('admin');

    //Invoice Route
    Route::get('/invoice-show/{order_id}', [InvoiceController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/invoice-print/{order_id}', [InvoiceController::class, 'printInvoice'])->name('invoice.print');
    Route::post('/order-details/{orderDetailId}/update-discount', [InvoiceController::class, 'updateDiscount'])->name('update-discount');
    Route::post('/update-exp-date/{order}', [OrderController::class, 'updateExpDate'])->name('update.exp_date');
});
