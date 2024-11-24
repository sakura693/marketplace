<?php

namespace App\Http\Controllers\Auth; /*Authを追加*/

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller; /*追加*/
use App\Actions\Fortify\CreateNewUser; /*追加*/
use Illuminate\Support\Facades\Auth; /*追加*/

class RegisterController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser){
        $this->createNewUser = $createNewUser;
    }

    public function register(Request $request){
        $user = $this->createNewUser->create($request->all());

        Auth::login($user);
        return redirect('/mypage/profile');
    }
}
