<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

use App\Http\Requests\LoginRequest; // LoginRequestをインポート

use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;



class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*ユーザーを新しく作成する方法を指定するコード。CreateNewUserクラスでユーザー作成のルールや処理を定義。 */
        Fortify::createUsersUsing(CreateNewUser::class);
        
        /*Fortifyで登録画面を取得*/
        Fortify::registerView(function(){
            return view('auth.register');
        });

        /*Fortifyでログイン画面を取得*/
        Fortify::loginView(function(){
            return view('auth.login');
        });


        /*リダイレクト先指定
        Fortify::registered(function ($request, $user){
            return redirect('/mypage/profile');
        });*/

        
        /*Fortify::authenticateUsing(function (Request $request){
            Log::info('Login attempt:', $request->all());
            $loginRequest = new LoginRequest();
            $loginRequest->merge($request->only('email', 'password', 'remember'));
            
            try{
                $loginRequest->validateResolved();
            } catch(\Illuminate\Validation\ValidationException $e){
             Log::error('Validation failed:', $e->errors());
             return null;
             }         
             
            $credentials = $request->only('email','password');

            if (Auth::attempt($credentials, $request->boolean('remember'))){
                return Auth::user();
            }
            
            return null;
        });*/
        

        /*特定のメールアドレスのユーザーが1分間に最大10回ログイン試行をできるよう制限する設定*/
        RateLimiter::for('login', function(Request $request){
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
