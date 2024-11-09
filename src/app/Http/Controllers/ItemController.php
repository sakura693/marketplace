<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Status; /*追加*/
use App\Models\Category; /*追加*/
use App\Models\PaymentMethod; /*追加*/
use App\Models\Item; /*追加*/


class ItemController extends Controller
{
    

    
     /*（仮）商品一覧画面を出力*/
    public function index(){
        $items = Item::all();
        return view('item', compact('items'));
    }

    /*（仮）商品出品画面を出力*/
    public function sell(){
        $categories = Category::all();
        $statuses = Status::all();
        return view('sell', compact('statuses', 'categories'));
    }

    /*（仮）商品詳細画面を出力*/
    public function detail(){
        return view('detail');
    }

    /*（仮）商品購入画面を出力*/
    public function purchase(){
        $payment_methods = PaymentMethod::all();
        return view('purchase', compact('payment_methods'));
    }

     /*（仮）商品購入画面を出力*/
    public function address(){
        return view('address');
    }


    
}
