<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_name(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $itemA = Item::factory()->create(['name' => 'item A']);
        $itemB = Item::factory()->create(['name' => 'item B']);
        Item::factory()->create(['name' => 'Something Else']);
        
        $response = $this->get('/search?keyword=Item');

        $response->assertSeeText($itemA->name);
        $response->assertSeeText($itemB->name);
        $response->assertSee($itemA->image);
        $response->assertSee($itemB->image);

        $response->assertDontSeeText('Something Else');
    }
}
