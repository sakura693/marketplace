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

/*（仮）会員登録画面を取得*/
Route::get('/register', [ItemController::class, 'register']);
