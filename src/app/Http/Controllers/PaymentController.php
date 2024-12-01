<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; /*追加*/
use App\Models\Order; /*追加*/
use Laravel\Cashier\Checkout; /*追加*/
use Stripe\Checkout\Session; /*Stripeのセッション作成用*/
use Stripe\Stripe;  /*追加*/
use App\Http\Requests\PurchaseRequest; /*追加*/

class PaymentController extends Controller
{
    /*商品購入機能*/
    public function checkout(PurchaseRequest $request, $itemId)
    {
        /*ログイン中のユーザーを取得*/
        $user = $request->user();
        $item = Item::findOrFail($itemId);
        $paymentMethodId = $request->input('payment_method');

        if ($paymentMethodId == 1) {
            $paymentMethodType = 'konbini';  // コンビニ払い
        } else {
            $paymentMethodType = 'card';  // カード払い
        } 

        // 商品の説明と金額を設定
        $description = '購入: ' . $item->name; // 商品名
        $amount = $item->price; // 金額（セント単位）

         // Stripe APIキー設定（テストモード）
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // リダイレクト先URLを設定
        $successUrl = route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&item_id=' . $item->id . '&payment_method_id=' . $paymentMethodType;

        // Stripe Checkoutセッションを作成
        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$paymentMethodType],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $description, // 商品名として表示
                    ],
                    'unit_amount' => $amount, // 価格として表示
                ],
                'quantity' => 1, // 個数（デフォルト1）
            ]],
            'mode' => 'payment', // 支払いモード
            'success_url' => $successUrl, // 成功時リダイレクト先
        ]);
        return redirect()->away($checkoutSession->url);
    }

    public function success(Request $request)
    {
        // StripeのCheckoutセッションIDを取得
        $sessionId = $request->query('session_id');
        $itemId = $request->query('item_id');
        $paymentMethodType = $request->query('payment_method_id');

        if ($paymentMethodType === 'card') {
            $paymentMethodId = 2; // カード払いのID
        } elseif ($paymentMethodType === 'konbini') {
            $paymentMethodId = 1; // コンビニ払いのID
        }

        // 注文をDBに保存
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $itemId, 
            'payment_method_id' => $paymentMethodId,
            'stripe_session_id' => $sessionId,
        ]);

        $item = Item::findOrFail($itemId);
        /*商品を購入済みに更新*/
        $item->sold = true; /*itemsテーブルのsoldカラムをfalse→true*/
        $item->save();

        // 支払い成功後の処理
        return view('payment-success'); 
    }
}
