<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 
use App\Models\Category;
use App\Models\Comment; 
use App\Models\Status; 

class ItemDetailListTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_displays_correct_information(){
        $this->seed(); 

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $categories = Category::inRandomOrder()->limit(3)->get();

        $status = Status::inRandomOrder()->first();

        $item = Item::factory()->create();
        $item->categories()->attach($categories);

        $comment = Comment::factory()->create(['item_id' => $item->id, 'user_id' => $user->id]);

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);

        $response->assertSee($item->image);
        $response->assertSeeText($item->name);
        $response->assertSeeText($item->price);
        $response->assertSeeText($item->description);

        foreach ($item->categories as $category) {
            $response->assertSeeText($category->name);
        }

        $response->assertSeeText($comment->comment);
        $response->assertSeeText($comment->user->name);
        $response->assertSeeText($comment->user->image);
        
        $commentsCount = $comment->count();
        $response->assertSeeText((string)$commentsCount);

        $likesCount = $item->likes->count();
        $response->assertSeeText((string)$likesCount);

        $response->assertSeeText($item->status->status); 
    }
        
}
