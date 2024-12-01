<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Status; /*追加*/
use App\Models\PaymentMethod; /*追加*/

class PurchaseTest extends TestCase
{
    use RefreshDatabase;  

    public function test_item_purchase_flow()
    {
        $this->seed();
        /*Step 1: ユーザーをログイン状態にする*/
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create([
            'sold' => false, //未購入状態
        ]);

        $payment_method = PaymentMethod::inRandomOrder()->first();

        //Step 2: 商品購入画面を開く
        $purchasePageResponse = $this->get("/purchase/{$item->id}");
        // ページが正しく表示されるか確認
        $purchasePageResponse->assertStatus(200); 


        // Step 3: 「購入する」ボタンを押す
        $purchaseResponse = $this->post('/mypage',  [
            'item_id' => $item->id,
            'payment_method' => $payment_method->id,
        ]);
        // 購入処理が成功したらリダイレクトするから200ではなく302が返されればいい
        $purchaseResponse->assertStatus(302); 
        

        // データベースの確認:sold=trueに更新されているか
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'sold' => true,
        ]);

        // データベースの確認:購入履歴が登録されているか
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $payment_method->id,
        ]);

        // Step 4: 商品一覧画面を表示する
        $itemsPageResponse = $this->get('/');
        $itemsPageResponse->assertStatus(200); 
        // 商品が「sold」と表示されているか確認
        $itemsPageResponse->assertSeeText('sold'); 

        // Step 5: プロフィール画面を表示する
        $profilePageResponse = $this->get('/mypage?tab=buy');
        $profilePageResponse->assertStatus(200); 
        $profilePageResponse->assertSeeText($item->name); 
        $profilePageResponse->assertSee($item->image);
    }
}
