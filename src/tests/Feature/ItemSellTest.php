<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/
use App\Models\Status; /*追加*/
use App\Models\Category; /*追加*/
use App\Models\ProductCategory; /*追加*/

class ItemSellTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_selling_by_authenticated_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);

        // 出品画面にアクセス
        $response = $this->get('/sell');
        $response->assertStatus(200);

        // 既存のStatusとCategoryを取得
        $status = Status::first();
        $category = Category::first();

        // 出品する商品データ
        $itemData = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status_id' => $status->id,
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'price' => 5000,
            'image' => 'dummy.jpg',
        ];

        /*商品を保存*/
        $response = $this->post('/', $itemData);

        // 商品が正しく保存されたかを確認
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'price' => 5000,
            'image' => 'dummy.jpg',
        ]);

        $this->assertDatabaseHas('product_category', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}
