<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 

class ItemListTest extends TestCase
{
    use RefreshDatabase;   

    public function test_can_get_all_items(){
        $user = User::factory()->create();

        $items = Item::factory()->count(5)->create();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSeeText($item->name);
            $response->assertSee($item->image); 
        }
    }

    public function test_sold_items_display_as_sold(){
        $user = User::factory()->create();
        $items = Item::factory()->count(3)->create(['sold' => true]); 
        
        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSeeText($item->name);
            $response->assertSee($item->image); 
            $response->assertSeeText('sold');
        }
    }

    public function test_own_items_are_not_displayed(){
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]); 
        $otherUserItem = Item::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertDontSeeText($item->name);
        $response->assertDontSee($item->image);

        $response->assertSeeText($otherUserItem->name);
        $response->assertSee($otherUserItem->image);
    }
}
