<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;

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

// Route::get('/', function () {
//     return view('layouts.layout');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

# Store Routes
Route::get('/add_store', [MainController::class, 'store'])->name('add_store')->middleware('auth');
Route::post('/add_store', [MainController::class, 'create_store'])->name('create_store')->middleware('auth');
Route::get('/stores/{name}/{id}', [MainController::class, 'store_products'])->name('store_products')->middleware('auth');


# Product Routes
Route::get('/add_product', [MainController::class, 'product'])->name('add_product')->middleware('auth');
Route::post('/add_product/create', [MainController::class, 'create_product'])->name('create_product')->middleware('auth');


# User Profile (Product List) Route
Route::get('/your_products', [MainController::class, 'user_profile'])->name('user_profile')->middleware('auth');


