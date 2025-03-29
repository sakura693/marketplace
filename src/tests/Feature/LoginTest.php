<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_email_is_required(){
        $response = $this->post('/login',[
            'email' => '', 
            'password' => '12345678',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required(){
        $response = $this->post('/login',[
            'email' => $this->faker->unique()->safeEmail, 
            'password' => '', 
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_validation_messages_are_displayed_for_invalid_input(){
        $response = $this->post('/login',[
            'email' => 'invalid-email', 
            'password' => '123456',
        ]);
        $response->assertSessionHasErrors([
            'email',
            'password',
        ]);
    }

    public function test_login_succeeds_with_valid_input(){
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'correct_password',
        ]);

        $response->assertRedirect('/'); 
        $this->assertAuthenticatedAs($user); 
    }

    public function test_user_can_logout(){
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $this->actingAs($user); 
        $response = $this->post('/logout');
        $this->assertGuest();

    }
}
