<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/
use App\Models\Status; /*追加*/

class CommentTest extends TestCase
{
    use RefreshDatabase; 

    /*ログイン済みのユーザはコメントできる*/
    public function test_authenticated_user_can_post_comment()
    {
        $this->seed();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user);

        // コメントデータ（item_id と user_id を指定）
        $comment = Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id,]);

        // コメントがデータベースに追加されたか確認
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => $comment->comment,
        ]);

        // コメント投稿後にリダイレクトされることを確認
        $response = $this->post("/item/{$item->id}");
        
        $response->assertRedirect();
    }


    /*ログインしていないユーザはコメントできない*/
    public function test_guest_user_cannot_post_comment()
    {
        $item = Item::factory()->create([
            'status_id' => Status::inRandomOrder()->first()->id,  // Statusも関連データとして生成
        ]);

        /*ログインしていない状態でコメントを送信*/
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
            'status_id' => Status::inRandomOrder()->first()->id,  // Statusも関連データとして生成
        ]);
        $this->actingAs($user);

        // ログインしていない状態でコメントなしで送信
        $response = $this->post("/item/{$item->id}", [
            'comment' => '', // 空のコメント
        ]);

        // コメントが空の場合、バリデーションエラーメッセージが存在することを確認
        $response->assertSessionHasErrors('comment');
    }


    public function test_guest_user_cannot_post_comment_over_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'status_id' => Status::inRandomOrder()->first()->id,
        ]);
        $this->actingAs($user);

        // コメントが255字以上の場合に送信
        $longComment = str_repeat('a', 256); // 256文字のコメント

        $response = $this->post("/item/{$item->id}", [
            'comment' => $longComment, // 長すぎるコメント
        ]);

        // コメントが255文字を超えている場合、バリデーションエラーメッセージが存在することを確認
        $response->assertSessionHasErrors('comment');
    }
}
