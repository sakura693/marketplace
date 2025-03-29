<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest; 
use Illuminate\Support\Facades\Auth; 
use Laravel\Fortify\Contracts\LoginResponse; 

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
