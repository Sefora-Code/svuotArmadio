<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('/users', UsersController::class);
Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    
Route::post('/assign-order', [OrdersController::class, 'assign'])->name('order.assign');
Route::post('/accept-order', [OrdersController::class, 'accept'])->name('order.accept');
Route::post('/reject-order', [OrdersController::class, 'reject'])->name('order.reject');
Route::post('/store-order', [OrdersController::class, 'storeAdminOrder'])->name('store.order');
