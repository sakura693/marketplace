<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; 
use App\Http\Requests\AddressRequest; 
use App\Models\Profile; 
use App\Models\Item; 
use App\Models\User; 
use App\Models\Order; 
use Illuminate\Support\Facades\Auth; 


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
            $orders = Order::with('item')->where('user_id', $user->id)->get();

            $items = $orders->map(function ($order) {
            return $order->item;
            });
        }
        
        return view('profile', compact('items', 'user'));
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
