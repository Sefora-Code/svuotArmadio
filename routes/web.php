<?php

use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;
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
Route::get('/customers', [UsersController::class, 'index'])->name('customers');
Route::get('/riders', [UsersController::class, 'index'])->name('riders');
Route::get('/rider-orders/{id}', [OrdersController::class, 'showTodayUserOrders'])->name('rider.ordering.pickups');
Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    
Route::post('/assign-order', [OrdersController::class, 'assign'])->name('order.assign');
Route::post('/accept-order', [OrdersController::class, 'accept'])->name('order.accept');
Route::post('/reject-order', [OrdersController::class, 'reject'])->name('order.reject');
Route::post('/store-order', [OrdersController::class, 'storeAdminOrder'])->name('store.order');
Route::post('/pickups-ordering', [OrdersController::class, 'confirmPickupsOrdering'])->name('pickups.ordering.confirm');
Route::get('/customers/info', [CustomersController::class, 'index'])->name('informations');

Route::get('/front-home', [FrontPageController::class, 'index'])->name('front-home');
Route::post('/update-user', [UsersController::class, 'update'])->name('save-user-data');

Route::get('/orders-home', [FrontPageController::class, 'ordersHome'])->name('orders-home');
Route::post('/new-order', [OrdersController::class, 'store'])->name('new-order');
Route::get('/show-order/{id}', [OrdersController::class, 'show'])->name('show-order');
Route::get('/edit-order/{id}', [OrdersController::class, 'edit'])->name('edit-order');
Route::post('/update-order/{id}', [OrdersController::class, 'update'])->name('update-order');
Route::get('/payment-order/{id}', [OrdersController::class, 'paymentPage'])->name('payment-order');

Route::get('/pickups-home', [FrontPageController::class, 'pickupsHome'])->name('pickups-home');
Route::get('/pickups-detail/{id}', [OrdersController::class, 'showDetail'])->name('pickups-detail');

Route::get('/pickups-map-emp', [FrontPageController::class, 'pickupsMapEmp'])->name('pickups-map-emp');
Route::get('/pickups-detail-emp/{id}', [OrdersController::class, 'showDetailEmp'])->name('pickups-detail-emp');
Route::get('/pickups-get-today/{empId}', [OrdersController::class, 'getTodayUserOrders'])->name('pickups-get-today');

Route::get('/update_order_status', [OrdersController::class, 'UpdateOrderStatus'])->name('update.order.status');