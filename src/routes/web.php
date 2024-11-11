<?php

use Illuminate\Support\Facades\Route;
/*コントローラを読み込む*/
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LoginController; 
use Laravel\Fortify\Fortify; /*追加*/
use App\Http\Controllers\ProfileController; /*追加*/

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


/*商品一覧画面を取得*/
Route::get('/', [ItemController::class, 'index']);

/*商品詳細画面を取得*/
Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::middleware('auth')->group(function () {
    /*（仮）プロフィール画面を取得*/
    Route::get('/mypage', [ProfileController::class, 'mypage']);

    /*（仮）商品出品画面を取得*/
    Route::get('/sell', [ItemController::class, 'sell']);

    /*（（仮））商品購入画面を取得*/
    Route::get('/purchase', [ItemController::class, 'purchase']);

    
});




/*（仮）プロフィール編集画面を取得*/
Route::get('/mypage/profile', [RegisterController::class, 'profile']);

/*（仮）patchメソッド*/
Route::patch('/', [ProfileController::class, 'update']);




/*（（仮））商品購入画面を取得*/
Route::get('/purchase/address', [ItemController::class, 'address']);

