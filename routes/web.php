<?php

use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/customers/info', [CustomersController::class, 'index'])->name('informations');

Route::get('/front-home', [FrontPageController::class, 'index'])->name('front-home');
Route::get('/bookings-home', [FrontPageController::class, 'bookingsHome'])->name('bookings-home');
Route::get('/pickups-home', [FrontPageController::class, 'pickupsHome'])->name('pickups-home');