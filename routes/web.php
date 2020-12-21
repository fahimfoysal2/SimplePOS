<?php

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

Route::get('/', function () {

    $user_level = auth()->user()->id;

    switch ($user_level) {
        case 1:
            return view('admin/admin', compact('user_level'));
            break;
        case 2:
            return view('manager/manager', compact('user_level'));
            break;

        case 3:
            return view('seller/seller', compact('user_level'));
            break;

        default:
            return view('home', compact('user_level'));

    }
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
