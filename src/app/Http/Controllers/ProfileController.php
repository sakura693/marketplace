<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile; /*追加*/
use App\Models\Item; /*追加*/

class ProfileController extends Controller
{
    /*（仮）マイページを取得*/
    public function mypage(){
        $items = Item::all();
        return view('profile', compact('items'));
    }
}
