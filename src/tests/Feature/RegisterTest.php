<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_name_is_required(){
        $response = $this->post('/register', [
            'name' => '', 
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '', 
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '', 
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_password_is_minimum_8_characters(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '1234567', 
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_must_match(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',  
            'password_confirmation' => 'differentpassword',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_all_fields_filled(){
        
        $email = $this->faker->unique()->safeEmail;

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $email,
            'password' => '12345678',  
            'password_confirmation' => '12345678',
        ]);

        $response->assertRedirect('/mypage/profile');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => $email, 
        ]);

        $user = \App\Models\User::where('email', $email)->first();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('12345678', $user->password));
    }
}
