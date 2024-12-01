<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Item; 
use App\Models\Status; 
use App\Models\PaymentMethod; 
use Livewire\Livewire; 
use App\Http\Livewire\PurchaseDetails;

class PurchaseFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_selection_updates_in_subtotal_page()
    {
        $this->seed();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $payment_methods = PaymentMethod::all(); 

        Livewire::actingAs($user);

        $component = Livewire::test(PurchaseDetails::class, [
            'item' => $item,
            'user' => $user,
            'payment_methods' => $payment_methods
        ]);

        $payment_method = $payment_methods->first();

        $component ->set('selectedPaymentMethod', $payment_method->id);  

        $component->assertSee($payment_method->payment_method);
    }
}
