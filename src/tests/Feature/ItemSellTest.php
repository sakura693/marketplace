<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item; 
use App\Models\User; 
use App\Models\Status; 
use App\Models\Category; 
use App\Models\ProductCategory; 

class ItemSellTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_selling_by_authenticated_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $status = Status::first();
        $category = Category::first();

        $itemData = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status_id' => $status->id,
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'price' => 5000,
            'image' => 'dummy.jpg',
        ];

        $response = $this->post('/', $itemData);

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
