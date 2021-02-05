<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
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

# User Profile (Product List) Route
Route::get('/your_products', [HomeController::class, 'user_profile'])->name('user_profile')->middleware('auth');
Route::get('/', [HomeController::class, 'index'])->name('home');


# Store Routes
Route::get('/add_store', [StoreController::class, 'store'])->name('add_store')->middleware('auth');
Route::post('/add_store', [StoreController::class, 'create_store'])->name('create_store')->middleware('auth');

Route::get('/store/{name}/{id}', [StoreController::class, 'store_products'])->name('store_products')->middleware('auth');
Route::get('/edit_store/{name}/{id}', [StoreController::class, 'edit_store'])->name('edit_store')->middleware('auth');
Route::post('/store/delete', [StoreController::class, 'delete_store'])->name('delete_store')->middleware('auth');


# Product Routes
Route::get('/add_product', [ProductController::class, 'product'])->name('add_product')->middleware('auth');
Route::post('/add_product/create', [ProductController::class, 'create_product'])->name('create_product')->middleware('auth');

Route::get('/product_details/{store_name}/{store_id}/{product_name}/{product_id}/{curstom_url}', [ProductController::class, 'product_details'])->name('product_details')->middleware('auth');
Route::get('/product_details/unassigned_store/{product_name}/{product_id}/{curstom_url}', [ProductController::class, 'unassigned_product_details'])->name('unassigned_product_details')->middleware('auth');

Route::get('/edit_product/{store_id}/{product_name}/{product_id}/{custom_url}', [ProductController::class, 'edit_product'])->name('edit_product')->middleware('auth');
Route::post('/edit_product/save', [ProductController::class, 'save_edit_product'])->name('save_edit_product')->middleware('auth');

Route::post('/product/delete', [ProductController::class, 'delete_product'])->name('delete_product')->middleware('auth');



