<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 
use App\Models\Like; 
use App\Models\Status; 

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_unlike_item()
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([]);        

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->post("/item/{$item->id}/like");  
        $response->assertStatus(302);  

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->post("/item/{$item->id}/like"); 
        $response->assertStatus(302);  

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
