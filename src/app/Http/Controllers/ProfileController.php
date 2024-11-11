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
    /*（仮）マイページを取得*/
    public function mypage(){
        $items = Item::all();
        return view('profile', compact('items'));
    }


    /*（仮）プロフィールを保存*/
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
}
