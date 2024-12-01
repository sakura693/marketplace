<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Like; /*追加*/
use App\Models\Status; /*追加*/

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_unlike_item()
    {
         /*Itemでstatusを受け取るからシーディングが必要*/
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([]);        

        /*初期状態ではいいねされていないからまだレコードはないはず。likesテーブルを確認(DatabaseMissingはレコードがないことを確かめる)*/
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        /*いいね追加のリクエスト*/
        $response = $this->post("/item/{$item->id}/like");  
        /*リダイレクトされる*/
        $response->assertStatus(302);  

        /*いいねをつけたことでlikesテーブルにレコードが追加されているか確認（DatabaseHasはデータベースにレコードがあるか確認）*/
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        /*再度いいねリクエストを送り解除*/
        $response = $this->post("/item/{$item->id}/like");  /*いいね解除のリクエスト*/
        $response->assertStatus(302);  

        /*いいねが解除され、likesテーブルにレコードが削除されてるか確認*/
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
