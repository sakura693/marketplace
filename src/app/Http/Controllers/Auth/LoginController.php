<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest; /*追加*/
use Illuminate\Support\Facades\Auth; /*追加*/
use Laravel\Fortify\Contracts\LoginResponse; /*追加*/

class LoginController extends Controller
{
    public function store(LoginRequest $request){
        $validated = $request->validated();

        if(Auth::attempt($request->only('email', 'password'))){
            return app(LoginResponse::class);
        }
        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ]);
    }

    public function destroy(){
        Auth::logout();
        return redirect('/');
    }
}
