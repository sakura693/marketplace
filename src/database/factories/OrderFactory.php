<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order; /*追加*/
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\PaymentMethod; /*追加*/

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method_id' => null, // テスト内で PaymentMethodのレコードを作成するからファクトリではpayment_method_id設定しない
        ];
    }
}
