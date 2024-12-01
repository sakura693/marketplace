<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentMethod;


class UserMypageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_display()
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);

        /*マイページに遷移*/
        $response = $this->get("/mypage");
        $response->assertStatus(200);

        $response->assertSeeText($user->name);
        $response->assertSee($user->image);

       // 出品した商品を作成
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        // 購入した商品を作成
        $buyItem = Item::factory()->create();

        // 支払い方法の取得
        $payment_methods = PaymentMethod::all(); // 全ての支払い方法を取得
        $payment_method = $payment_methods->first(); // 最初の支払い方法を取得

        // ユーザーが購入した注文を作成
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'payment_method_id' => $payment_method->id, // 既存のレコードを参照
        ]);

        // 出品した商品が表示されるか確認
        $response = $this->get("/mypage?tab=sell");
        $response->assertStatus(200);
        $response->assertSee($sellItem->name);
        $response->assertSee($sellItem->image);

        // 購入した商品が表示されるか確認
        $response = $this->get("/mypage?tab=buy");
        $response->assertStatus(200);
        $response->assertSee($buyItem->name);
        $response->assertSee($buyItem->image);
    }
}
