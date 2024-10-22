<?php

use Illuminate\Support\Facades\Route;
/*コントローラを読み込む*/
use App\Http\Controllers\ItemController; 

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

/*会員登録画面を取得*/
Route::get('/register', [ItemController::class, 'register']);

/*storeメソッド*/
Route::post('/mypage/profile', [ItemController::class, 'store']);

/*（仮）プロフィール編集画面を取得*/
Route::get('/mypage/profile', [ItemController::class, 'profile']);


/*（仮）ログイン画面を取得*/
Route::get('/login', [ItemController::class, 'login']);

/*（仮）商品一覧画面を取得*/
Route::get('/', [ItemController::class, 'index']);
