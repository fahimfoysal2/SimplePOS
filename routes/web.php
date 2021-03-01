<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/***********************
 * Login / Logout Routes
 ***********************/

Auth::routes();
Route::get('logout', function () {
    echo "<center><h1> No direct access </h1></center>";
});

/******************
 * Home Page Routes
 ******************/

Route::get('/', [HomeController::class, 'index']);
Route::get('{path}', [HomeController::class, 'index'])
    ->where('path', 'home|admin')
    ->name('home');

/***************
 * Admin Routes
 ***************/

Route::prefix('admin')->group(function () {
    Route::get('roles', [AdminController::class, 'manageRoles'])->name('manageRoles');

    Route::get('users', [AdminController::class, 'manageUsers'])->name('manageUsers');
    Route::get('users/remove/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::post('users/update', [AdminController::class, 'updateUser'])->name('updateUser');
});

/********************
 * Product Routes
 ********************/

Route::prefix('product')->group(function () {
    Route::get('manage', [ProductController::class, 'index'])
        ->name('product.manage');

    Route::post('save', [ProductController::class, 'store'])
        ->name('product.save');

    Route::get('all', [ProductController::class, 'showAll'])
        ->name('product.all');

    Route::get('remove', [ProductController::class, 'destroy'])
        ->name('product.remove');

    Route::get('edit', [ProductController::class, 'edit'])
        ->name('product.edit');

    Route::post('update', [ProductController::class, 'update'])
        ->name('product.update');

    Route::get('find', [SalesController::class, 'findProduct'])
        ->name('product.find');
});


/****************
 * Seller Routes
 ****************/
Route::prefix('sell')->group(function () {
    Route::get('/', [SalesController::class, 'index'])
        ->name('sell');

    Route::get('toCart', [SalesController::class, "getOneProduct"])
        ->name('tocart');

    Route::get('complete', [SalesController::class, "completeSell"])
        ->name('sell.complete');
});
