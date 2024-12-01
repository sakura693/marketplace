<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Category; /*追加*/
use App\Models\Comment; /*追加*/
use App\Models\Status; /*追加*/

class ItemDetailListTest extends TestCase
{
    use RefreshDatabase;

    /*必要な情報が表示される*/
    public function test_item_detail_displays_correct_information(){
        /*この記述によってシーディングが行われるからめっちゃ大事。これがないとStatusやCategoryを参照できない*/
        $this->seed(); 

        $user = User::factory()->create();
        $this->actingAs($user);
        
        /*既存のカテゴリをランダムに取得（例:3つのカテゴリ）*/
        $categories = Category::inRandomOrder()->limit(3)->get();

        $status = Status::inRandomOrder()->first();

        $item = Item::factory()->create();
        $item->categories()->attach($categories);

        $comment = Comment::factory()->create(['item_id' => $item->id, 'user_id' => $user->id]);

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);

        /*商品の画像、名前、価格、説明が表示されているか*/
        $response->assertSee($item->image);
        $response->assertSeeText($item->name);
        $response->assertSeeText($item->price);
        $response->assertSeeText($item->description);

        /*商品のカテゴリが表示されているか*/
        foreach ($item->categories as $category) {
            $response->assertSeeText($category->name);
        }

        /*商品のコメントが表示されているか*/
        $response->assertSeeText($comment->comment);
        $response->assertSeeText($comment->user->name);
        $response->assertSeeText($comment->user->image);
        

        /*コメント数が表示されるか*/
        $commentsCount = $comment->count();
        $response->assertSeeText((string)$commentsCount);

        /*いいね数が表示されるか確認*/
        $likesCount = $item->likes->count();
        $response->assertSeeText((string)$likesCount);

        /*商品の状態が表示されるか確認*/
        $response->assertSeeText($item->status->status); 
    }
        
}
