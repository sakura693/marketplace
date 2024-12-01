<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/

class ItemListTest extends TestCase
{
    use RefreshDatabase;   

    /*全商品を取得できる*/
    public function test_can_get_all_items(){
        /*テスト用のユーザを作成*/
        $user = User::factory()->create();

        /*テスト用の商品を５件データベースに作成*/
        $items = Item::factory()->count(5)->create();

        /*$userとして認証された状態にする*/
        $this->actingAs($user);

        /*/にgetリクエストを送る*/
        $response = $this->get('/');

        /*HTTPステータスコードが200 OKであるか確認*/
        $response->assertStatus(200);

        foreach ($items as $item) {
            /*名前が取得できているか*/
            $response->assertSeeText($item->name);
            /*写真が取得できているか*/ 
            $response->assertSee($item->image); 
        }
    }

    /*購入済み商品はsoldと表示される*/
    public function test_sold_items_display_as_sold(){
        $user = User::factory()->create();
        /*購入された商品*/
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

    /*自分が出品した商品は表示されない*/
    public function test_own_items_are_not_displayed(){
        $user = User::factory()->create();
        /*ログインユーザーの出品商品*/
        $item = Item::factory()->create(['user_id' => $user->id]); 
        /*他のユーザーの出品商品*/
        $otherUserItem = Item::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertStatus(200);

        /*自分の商品は表示されないことを確認*/
        $response->assertDontSeeText($item->name);
        $response->assertDontSee($item->image);

        /*他のユーザーの商品は表示されるか確認*/
        $response->assertSeeText($otherUserItem->name);
        $response->assertSee($otherUserItem->image);
    }
}
