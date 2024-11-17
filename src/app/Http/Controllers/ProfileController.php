<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; /*追加*/
use App\Models\Profile; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/
use Illuminate\Support\Facades\Auth; /*追加*/


class ProfileController extends Controller
{
    /*プロフィールを更新（住所など）*/
    public function update(ProfileRequest $request){
        $profiles = $request->all();
        if ($request->hasFile('image')){
            $path = $request->file('image')->store('image', 'public');

            $urlPath = str_replace('public/', $path);
            $urlPath = 'storage/' . $urlPath;

            $profiles['image'] = $urlPath;
        }

        $user = Auth::user();
        $user->update($profiles);

        return redirect('/login');
    }


    /*（仮）住所編集画面を出力*/
    public function address(){
        return view('address');
    }



    /*（仮）マイページを取得*/
    public function mypage(){
        $items = Item::all();
        return view('profile', compact('items'));
    }
}
