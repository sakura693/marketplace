<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ItemController extends Controller
{
    /*（仮）会員登録画面を出力*/
    public function register(){
        return view('register');
    }
}
