<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

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
});
