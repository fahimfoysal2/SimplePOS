<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Auth::routes();

Route::get('logout', function (){
    echo "<center><h1> No direct access </h1></center>";
});

Route::get('/', [HomeController::class, 'index']);
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->group(function (){
    Route::get('roles', [AdminController::class, 'manageRoles'])->name('manageRoles');

    Route::get('users', [AdminController::class, 'manageUsers'])->name('manageUsers');
    Route::get('users/remove/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::post('users/update', [AdminController::class, 'updateUser'])->name('updateUser');
});

Route::prefix('product')->group(function (){
    Route::get('manage', [ProductController::class, 'index'])
        ->name('manageProducts');

    Route::post('save', [ProductController::class, 'store'])
        ->name('saveProduct');
});
