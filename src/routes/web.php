<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LoginController; 
use Laravel\Fortify\Fortify; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\PaymentController; 


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


Route::get('/', [ItemController::class, 'index']);

Route::get('/item/{item_id}', [ItemController::class, 'show']);


Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'mypage']);

    Route::get('/sell', [ItemController::class, 'sell']);

    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);

    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address']);

    Route::patch('/purchase/address/{item_id}/update', [ProfileController::class, 'addressUpdate']);

    Route::post('/item/{item_id}', [ItemController::class, 'store']);

    Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('like.toggle');

    Route::post('/', [ItemController::class, 'register']);

    Route::get('/search', [ItemController::class, 'search']);

    Route::get('/mypage/profile', [ProfileController::class, 'editProfile']);

    Route::patch('/', [ProfileController::class, 'profileUpdate']);

    Route::post('/checkout/{item}', [PaymentController::class, 'checkout']);
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});






