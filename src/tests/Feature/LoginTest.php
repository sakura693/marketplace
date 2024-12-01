<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /*メールアドレスが入力されていない場合*/
    public function test_email_is_required(){
        $response = $this->post('/login',[
            'email' => '', /*emailが空の場合*/
            'password' => '12345678',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /*パスワードが入力されていない場合*/
    public function test_password_is_required(){
        $response = $this->post('/login',[
            'email' => $this->faker->unique()->safeEmail, 
            'password' => '', /*passwordが空の場合*/
        ]);
        $response->assertSessionHasErrors('password');
    }

    /*入力情報が間違っている場合*/
    public function test_validation_messages_are_displayed_for_invalid_input(){
        $response = $this->post('/login',[
            'email' => 'invalid-email', /*不正なメール形式*/
            'password' => '123456',
        ]);
        $response->assertSessionHasErrors([
            'email',
            'password',
        ]);
    }

    /*正しい情報が入力された場合*/
    public function test_login_succeeds_with_valid_input(){
        /*テスト用*/
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        /*正しいログイン情報を送信*/
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'correct_password',
        ]);

        /*認証が成功したことを確認*/
        $response->assertRedirect('/'); /*ログイン後/にリダイレクト*/
        $this->assertAuthenticatedAs($user); /*ユーザが認証されているか*/
    }

    /*ログアウトできるか確認*/
    public function test_user_can_logout(){
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        /*ユーザをログイン状態にする*/
        $this->actingAs($user); 

        /*ログアウトリクエスト送信*/
        $response = $this->post('/logout');

        /*ユーザが認証されていないことを確認*/
        $this->assertGuest();

    }
}
