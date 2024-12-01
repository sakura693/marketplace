<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 
use App\Models\Status; 
use App\Models\PaymentMethod;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;  

    public function test_item_purchase_flow()
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create([
            'sold' => false, 
        ]);

        $payment_method = PaymentMethod::inRandomOrder()->first();

        $purchasePageResponse = $this->get("/purchase/{$item->id}");
        $purchasePageResponse->assertStatus(200); 

        $purchaseResponse = $this->post('/mypage',  [
            'item_id' => $item->id,
            'payment_method' => $payment_method->id,
        ]);
        $purchaseResponse->assertStatus(302); 
        
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'sold' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $payment_method->id,
        ]);

        $itemsPageResponse = $this->get('/');
        $itemsPageResponse->assertStatus(200); 
        $itemsPageResponse->assertSeeText('sold'); 

        $profilePageResponse = $this->get('/mypage?tab=buy');
        $profilePageResponse->assertStatus(200); 
        $profilePageResponse->assertSeeText($item->name); 
        $profilePageResponse->assertSee($item->image);
    }
}
