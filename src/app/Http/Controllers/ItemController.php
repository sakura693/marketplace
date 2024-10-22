<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;


class ItemController extends Controller
{
    /*会員登録画面を出力*/
    public function register(){
        return view('register');
    }

    /*会員情報を保存してプロフィール設定画面に飛ぶ*/
    public function store(RegisterRequest $request){
        $users = $request->all();
        $user = User::create($users);
        return redirect('/mypage/profile'); /*リダイレクト先のパスを設定*/
    }

    /*LoginRequest $request*/

    /*（仮）ログイン画面を出力*/
    public function login(){
        return view('login');
    }

     /*（仮）商品一覧画面を出力*/
    public function index(){
        return view('item');
    }

    /*（仮）プロフィール画面を出力*/
    public function profile(){
        return view('edit-profile');
    }
}
