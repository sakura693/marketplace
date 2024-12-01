<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Order; /*追加*/

class AddressUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_address_update_and_purchase_flow()
    {
        $this->seed();
        $item = Item::factory()->create();
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
        $this->actingAs($user);

        /*購入画面に遷移し登録済みの住所情報が表示される*/
        $purchaseResponse = $this->get("/purchase/{$item->id}");
        $purchaseResponse->assertStatus(200);
        $purchaseResponse->assertSee('123-4567');
        $purchaseResponse->assertSee('東京都渋谷区');
        $purchaseResponse->assertSee('テストビル101');

        /*住所変更画面に遷移*/
        $addressResponse = $this->get("/purchase/address/{$item->id}");
        $addressResponse->assertStatus(200);

        /*住所を変更して保存*/
        $newAddressData = [
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名',
        ];

        $this->patch("/purchase/address/{$item->id}/update", $newAddressData);

        /*ユーザーの住所が更新されていることを確認*/
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名',
        ]);

        /*購入画面を開くと新しい住所が反映されてる*/
        $updatedPurchaseResponse = $this->get("/purchase/{item->id}");
        $updatedPurchaseResponse->assertStatus(200);
        $updatedPurchaseResponse->assertSee('123-4567');
        $updatedPurchaseResponse->assertSee('新しい住所');
        $updatedPurchaseResponse->assertSee('新しい建物名');

        /*プルダウンメニューで支払い方法を選択*/
        $payment_methods = PaymentMethod::all();
        $payment_method = $payment_methods->first();
        /*「購入する」ボタンを押す*/
        $purchaseResponse = $this->post('/mypage',  [
            'item_id' => $item->id,
            'payment_method' => $payment_method->id,
        ]);

        /*注文が正しく保存されていることを確認*/
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $payment_method->id,
        ]);

    }
}
