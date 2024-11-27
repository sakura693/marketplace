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


/*☆商品一覧画面を取得*/
Route::get('/', [ItemController::class, 'index']);

/*☆商品詳細画面を取得*/
Route::get('/item/{item_id}', [ItemController::class, 'show']);

/*☆会員情報を保存*/
Route::post('/register', [RegisterController::class, 'register']);

/*☆ログイン*/
Route::post('/login', [LoginController::class, 'store']);

/*ログアウト*/
Route::post('/logout', [LoginController::class, 'destroy']);



/*認証済みユーザのみができること*/
Route::middleware('auth')->group(function () {
    /*☆プロフィール画面を取得*/
    Route::get('/mypage', [ProfileController::class, 'mypage']);

    /*☆商品出品画面を取得*/
    Route::get('/sell', [ItemController::class, 'sell']);

    /*☆商品購入画面を取得*/
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);

    /*☆住所変更画面を取得*/
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address']);

    /*住所更新(postメソッドでこの⇩ルートにアクセスした時addressUpdateメソッドを実行する) */
    Route::patch('/purchase/address/{item_id}/update', [ProfileController::class, 'addressUpdate']);

    /*コメントを保存*/
    Route::post('/item/{item_id}', [ItemController::class, 'store']);
    
    /*いいねしたり解除したらホームに戻る*/
    Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('like.toggle');

    /*商品を登録*/
    Route::post('/', [ItemController::class, 'register']);

    /*商品注文*/
    Route::post('/mypage', [ItemController::class, 'order']);

    /*商品検索*/
    Route::get('/search', [ItemController::class, 'search']);

    /*☆プロフィール編集画面を取得*/
    Route::get('/mypage/profile', [ProfileController::class, 'editProfile']);

    /*プロフィールを保存*/
    Route::patch('/', [ProfileController::class, 'profileUpdate']);
});






