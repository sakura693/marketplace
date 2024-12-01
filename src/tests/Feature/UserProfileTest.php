<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_display_on_profile_page()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'image' => 'images/test_image.jpg',
        ]);
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567'); 
        $response->assertSee('東京都渋谷区');  
        $response->assertSee('テストビル101');  
        $response->assertSee('images/test_image.jpg');
    }
}
