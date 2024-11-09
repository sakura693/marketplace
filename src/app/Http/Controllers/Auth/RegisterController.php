<?php

namespace App\Http\Controllers\Auth; /*Authを追加*/

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller; /*記述を追加*/

class RegisterController extends Controller
{
    /*（仮）プロフィール画面を出力*/
    public function profile(){
        return view('edit-profile');
    }
}
