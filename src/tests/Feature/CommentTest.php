<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Item; 
use App\Models\User;
use App\Models\Status; 

class CommentTest extends TestCase
{
    use RefreshDatabase; 

    public function test_authenticated_user_can_post_comment()
    {
        $this->seed();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user);

        $comment = Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id,]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => $comment->comment,
        ]);

        $response = $this->post("/item/{$item->id}");
        
        $response->assertRedirect();
    }

    public function test_guest_user_cannot_post_comment()
    {
        $item = Item::factory()->create([
            'status_id' => Status::inRandomOrder()->first()->id,
        ]);

        $response = $this->post("/item/{$item->id}", [
            'comment' => 'テストコメント',
        ]);

        $this->assertDatabaseMissing('comments', [
        'item_id' => $item->id,
        'comment' => 'テストコメント'
        ]);
    }


    public function test_guest_user_cannot_post_empty_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'status_id' => Status::inRandomOrder()->first()->id,
        ]);
        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}", [
            'comment' => '',
        ]);
        $response->assertSessionHasErrors('comment');
    }


    public function test_guest_user_cannot_post_comment_over_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'status_id' => Status::inRandomOrder()->first()->id,
        ]);
        $this->actingAs($user);

        $longComment = str_repeat('a', 256); 

        $response = $this->post("/item/{$item->id}", [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');
    }
}
