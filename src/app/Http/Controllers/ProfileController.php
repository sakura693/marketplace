<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; /*追加*/
use App\Http\Requests\AddressRequest; /*追加*/
use App\Models\Profile; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/
use App\Models\Order; /*追加*/
use Illuminate\Support\Facades\Auth; /*追加*/


class ProfileController extends Controller
{

    /*住所編集画面を出力*/
    public function address($item_id){
        $user = auth()->user();
        $item = Item::find($item_id);
        return view('address', compact('user', 'item'));
    }

    /*住所の更新*/
    public function addressUpdate(AddressRequest $request, $item_id){
        $address = $request->all();
        $user = Auth::user();
        $user->update($address);
        return redirect('/purchase/' . $item_id);
    }



    /*マイページ（プロフィール画面）を取得*/
    public function mypage(Request $request){

        /*クエリを取得*/
        $page = $request->query('page');
        $user = $request->user();

        /*itemsを定義*/
        $items = collect(); // 初期値として空のコレクションを定義 

        if ($page === 'sell'){
            $items = Item::where('user_id', $user->id)->get();
        }elseif ($page === 'buy'){
            $orders = Order::with('item')->where('user_id', $user->id)->get();

            $items = $orders->map(function ($order) {
            return $order->item;
            });
        }
        
        return view('profile', compact('items', 'user'));
    }


    /*マイページからプロフィール編集画面を取得*/
    public function editProfile(Request $request){
        $user = $request->user();

        return view('edit-profile', compact('user'));
    }

    /*（仮）プロフィールを更新（マイページから）*/
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
