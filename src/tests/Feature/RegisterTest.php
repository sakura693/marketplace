<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker; /*$fakerを使えるようにする*/

    /*name部分のバリデーションチェック*/
    public function test_name_is_required(){
        $response = $this->post('/register', [
            'name' => '', /*名前を省略*/
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        /*名前が空の場合エラーメッセージが表示されることを確認*/
        $response->assertSessionHasErrors('name');
    }

    /*email部分のバリデーションチェック*/
    public function test_email_is_required(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '', /*emailを省略*/
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /*password部分のバリデーションチェック*/
    public function test_password_is_required(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '',  /*passwordを省略*/
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors('password');
    }

    /*パスワードが７文字以下の場合*/
    public function test_password_is_minimum_8_characters(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '1234567',  /*7文字のパスワード*/
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
    }

    /*確認用パスワードが一致しない場合の確認*/
    public function test_password_confirmation_must_match(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',  
            'password_confirmation' => 'differentpassword',
        ]);
        $response->assertSessionHasErrors('password');
    }

    /*全部きちんと入力されているとききちんと/mypage/profileにリダイレクトし、usersテーブルに登録されるか*/
    public function test_all_fields_filled(){
        
        /*fakerで動的生成したメールアドレスを$emailに代入*/
        $email = $this->faker->unique()->safeEmail;

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $email,
            'password' => '12345678',  
            'password_confirmation' => '12345678',
        ]);

        /*リダイレクト先が/であることを確認*/
        $response->assertRedirect('/mypage/profile');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => $email, 
        ]);

        /*パスワードがハッシュ化されて保存されてるか確認*/
        $user = \App\Models\User::where('email', $email)->first();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('12345678', $user->password));
    }


}
