<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use App\Http\Requests\RegisterRequest; /*RegisterRequestを追加*/

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */

     // RegisterRequestを引数として受け取る
    public function create(array $input): User
    {
        // RegisterRequestのルールとカスタムメッセージを取得
        $rules = (new RegisterRequest)->rules();
        $messages = (new RegisterRequest)->messages();

        Validator::make($input, $rules, $messages)->validate();

        // Userを作成して返す
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
