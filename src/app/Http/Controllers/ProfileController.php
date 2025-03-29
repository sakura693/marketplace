<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\ProfileRequest; 
use App\Http\Requests\AddressRequest; 
use App\Models\Profile; 
use App\Models\Item; 
use App\Models\User; 
use App\Models\Order; 
use App\Models\Chat; 


class ProfileController extends Controller
{
    public function address($item_id){
        $user = auth()->user();
        $item = Item::find($item_id);
        return view('address', compact('user', 'item'));
    }

    public function addressUpdate(AddressRequest $request, $item_id){
        $address = $request->all();
        $user = Auth::user();
        $user->update($address);
        return redirect('/purchase/' . $item_id);
    }

    public function mypage(Request $request){
        $tab = $request->query('tab');
        $user = $request->user();
        $items = collect(); 

        if ($tab === 'sell'){
            $items = Item::where('user_id', $user->id)->get();
        }elseif ($tab === 'buy'){
            $orders = Order::with('item')->where('user_id', $user->id)->whereHas('item', function ($query){
                $query->where('sold', 2);
            })->get();

            $items = $orders->map(function ($order) {
            return $order->item;
            });
        }elseif($tab === 'in-transaction'){
            $orders = Order::with('item')->where('user_id', $user->id)->whereHas('item', function ($query){
                $query->where('sold', 1);
            })
            ->orWhereHas('item', function($query) use ($user) {
                $query->where('user_id', $user->id)->where('sold', 1);  
            })->get();

            $orderIds = $orders->pluck('id');

            $chats = Chat::whereIn('order_id', $orderIds)->orderBy('created_at', 'desc')->get();

            $orderedItemIds = $chats->map(fn($chat) => $chat->order_id)->unique()->toArray();

            $itemsWithChats = collect($orderedItemIds)->map(function ($orderId) use ($orders) {
                $order = $orders->firstWhere('id', $orderId);
                return isset($order) ? $order->item : null;
            })->filter(); 

            $itemsWithoutChats = $orders->reject(fn($order) => in_array($order->id, $orderedItemIds))->map(fn($order) => $order->item);

            $items = $itemsWithChats->merge($itemsWithoutChats);
        }

        $orders = Order::where(function($query) use ($user) {
            $query->where('user_id', $user->id)         
            ->orWhereHas('item', function($q) use ($user) {
                $q->where('user_id', $user->id); 
            });
        })->with('item')->get();
        
        $unreadCount = [];      
        $unreadTotal = 0;      
        foreach ($orders as $order) {
            $count = Chat::where('order_id', $order->id)
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();
            $unreadCount[$order->item->id] = $count; 
            $unreadTotal += $count;  
        }

        $ratings = [];  
        $sellerRating = Order::whereHas('item', function ($query) use ($user) {
            $query->where('user_id', $user->id); 
        })->avg('buyer_rating');
        $buyerRating = Order::where('user_id', $user->id)->avg('seller_rating');

        if ($sellerRating > 0) {
            $ratings['seller'] = round($sellerRating);
        }
        if ($buyerRating > 0) {
            $ratings['buyer'] = round($buyerRating);
        }
        
        if (isset($ratings['seller']) && isset($ratings['buyer'])) {
            $finalRating = ($ratings['seller'] + $ratings['buyer']) / 2;
        } elseif (isset($ratings['seller'])) {
            $finalRating = $ratings['seller'];
        } elseif (isset($ratings['buyer'])) {
            $finalRating = $ratings['buyer'];
        } else {
            $finalRating = 0; 
        }
        
        return view('profile', compact('items', 'user', 'tab', 'finalRating', 'unreadCount', 'unreadTotal'));
    }

    public function editProfile(Request $request){
        $user = $request->user();

        return view('edit-profile', compact('user'));
    }

    public function profileUpdate(AddressRequest $request){
        $profiles = $request->all();
        if ($request->hasFile('image')){
            $path = $request->file('image')->store('image', 'public');

            $urlPath = str_replace('public/', '', $path);
            $urlPath = 'storage/' . $urlPath;

            $profiles['image'] = $urlPath;
        }
        $user = Auth::user();
        $user->update($profiles);
        return redirect('/');
    }
}
