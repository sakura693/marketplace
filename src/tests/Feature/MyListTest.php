<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item; 
use App\Models\Like;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed(){
        $user = User::factory()->create();
        $likedItem = Item::factory()->create();
        $notLikedItem = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee($likedItem->name);
        $response->assertSee($likedItem->image);

        $response->assertDontSee($notLikedItem->name);
        $response->assertDontSee($notLikedItem->image);
    }

    public function test_sold_items_display_as_sold(){
        $user = User::factory()->create();
        $likedSoldItem = Item::factory()->create([
            'sold' => true
        ]); 

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedSoldItem->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSeeText($likedSoldItem->name);
        $response->assertSee($likedSoldItem->image);
        $response->assertSeeText('sold');
    }

    public function test_only_liked_items_are_displayed_and_own_items_are_not_included()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create(['user_id' => User::factory()->create()->id]);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $ownItem = Item::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSeeText($likedItem->name);
        $response->assertSee($likedItem->image);

        $response->assertDontSeeText($ownItem->name);
        $response->assertDontSee($ownItem->image);
    }

    public function test_nothing_is_displayed_if_not_authenticated(){
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200); 
        $response->assertSee('', false);
    }

}

    

