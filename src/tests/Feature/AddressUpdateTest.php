<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item; 
use App\Models\Order; 

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

        $purchaseResponse = $this->get("/purchase/{$item->id}");
        $purchaseResponse->assertStatus(200);
        $purchaseResponse->assertSee('123-4567');
        $purchaseResponse->assertSee('東京都渋谷区');
        $purchaseResponse->assertSee('テストビル101');

        $addressResponse = $this->get("/purchase/address/{$item->id}");
        $addressResponse->assertStatus(200);

        $newAddressData = [
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名',
        ];

        $this->patch("/purchase/address/{$item->id}/update", $newAddressData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名',
        ]);

        $updatedPurchaseResponse = $this->get("/purchase/{item->id}");
        $updatedPurchaseResponse->assertStatus(200);
        $updatedPurchaseResponse->assertSee('123-4567');
        $updatedPurchaseResponse->assertSee('新しい住所');
        $updatedPurchaseResponse->assertSee('新しい建物名');

        $payment_methods = PaymentMethod::all();
        $payment_method = $payment_methods->first();
        $purchaseResponse = $this->post('/mypage',  [
            'item_id' => $item->id,
            'payment_method' => $payment_method->id,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $payment_method->id,
        ]);

    }
}
