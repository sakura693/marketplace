<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Status; /*追加*/
use App\Models\PaymentMethod; /*追加*/
use Livewire\Livewire; /*追加*/
use App\Http\Livewire\PurchaseDetails; /*コンポーネント追加*/

class PurchaseFlowTest extends TestCase
{
    use RefreshDatabase;

    /*支払い方法選択画面での即時反映*/
    public function test_payment_method_selection_updates_in_subtotal_page()
    {
        $this->seed();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $payment_methods = PaymentMethod::all(); 

        /*Livewireコンポーネントをテストするためにログイン*/
        Livewire::actingAs($user);

        /*コンポーネントをインスタンス化*/
        $component = Livewire::test(PurchaseDetails::class, [
            'item' => $item,
            'user' => $user,
            'payment_methods' => $payment_methods
        ]);

        /*プルダウンメニューで支払い方法を選択*/
        $payment_method = $payment_methods->first();

        /*payment_methodをコンポーネントの変数名に置き換え*/
        $component ->set('selectedPaymentMethod', $payment_method->id);  

        /*支払い方法が反映されているか確認*/
        $component->assertSee($payment_method->payment_method);
    }
}
