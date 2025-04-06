<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
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

        $response = $this->get("/mypage");
        $response->assertStatus(200);

        $response->assertSeeText($user->name);
        $response->assertSee($user->image);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $buyItem = Item::factory()->create();

        $payment_methods = PaymentMethod::all();
        $payment_method = $payment_methods->first();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'payment_method_id' => $payment_method->id, 
        ]);

        $response = $this->get("/mypage?tab=sell");
        $response->assertStatus(200);
        $response->assertSee($sellItem->name);
        $response->assertSee($sellItem->image);

        $response = $this->get("/mypage?tab=buy");
        $response->assertStatus(200);
        $response->assertSee($buyItem->name);
        $response->assertSee($buyItem->image);
    }
}
