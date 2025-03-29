<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; 
use App\Models\Order; 
use Laravel\Cashier\Checkout; 
use Stripe\Checkout\Session; 
use Stripe\Stripe; 
use App\Http\Requests\PurchaseRequest; 

class PaymentController extends Controller
{
    public function checkout(PurchaseRequest $request, $itemId)
    {
        $user = $request->user();
        $item = Item::findOrFail($itemId);
        $paymentMethodId = $request->input('payment_method');

        if ($paymentMethodId == 1) {
            $paymentMethodType = 'konbini'; 
        } else {
            $paymentMethodType = 'card'; 
        } 

        $description = '購入: ' . $item->name; 
        $amount = $item->price; 

        Stripe::setApiKey(config('services.stripe.secret'));

        $successUrl = route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&item_id=' . $item->id . '&payment_method_id=' . $paymentMethodType;

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$paymentMethodType],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $description, 
                    ],
                    'unit_amount' => $amount, 
                ],
                'quantity' => 1, 
            ]],
            'mode' => 'payment', 
            'success_url' => $successUrl, 
        ]);
        return redirect()->away($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $itemId = $request->query('item_id');
        $paymentMethodType = $request->query('payment_method_id');

        if ($paymentMethodType === 'card') {
            $paymentMethodId = 2; 
        } elseif ($paymentMethodType === 'konbini') {
            $paymentMethodId = 1; 
        }

        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $itemId, 
            'payment_method_id' => $paymentMethodId,
            'stripe_session_id' => $sessionId,
        ]);

        $item = Item::findOrFail($itemId);
        $item->sold = 1; 
        $item->save();

        return view('payment-success'); 
    }
}
