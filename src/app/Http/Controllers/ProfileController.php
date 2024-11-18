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



    /*マイページ（プロフィール画面）を取得*/
    public function mypage(Request $request){

        /*クエリを取得*/
        $page = $request->query('page');
        $user = $request->user();

        if ($page === 'sell'){
            $items = Item::where('user_id', $user->id)->get();
        }else{
            $items = Item::all();/*（（仮））*/
        }
        
        return view('profile', compact('items', 'user'));
    }


    /*マイページからプロフィール編集画面を取得*/
    public function editProfile(Request $request){
        $user = $request->user();
        return view('edit-profile', compact('user'));
    }




    /*（仮）プロフィールを更新（マイページから）*/
    public function profileUpdate(ProfileRequest $request){
        $profiles = $request->all();
        $user = Auth::user();
        $user->update($profiles);
        return redirect('/mypage');
    }


}
