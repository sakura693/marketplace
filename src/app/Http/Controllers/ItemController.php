<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User; /*追加*/
use App\Models\Status; /*追加*/
use App\Models\Category; /*追加*/
use App\Models\PaymentMethod; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\ProductCategory; /*追加*/



class ItemController extends Controller
{
    
     /*商品一覧画面を出力*/
    public function index(){
        $items = Item::all();
        return view('item', compact('items'));
    }

    /*（仮）商品詳細画面を出力*/
    public function show($item_id){
        $item = Item::findOrFail($item_id);
        $product_category = ProductCategory::where('item_id', $item_id)->get();
         /*product_categoriesテーブルの中で、カラム名がitem_idであり、その値が$item_idと等しいレコードを取得する。
         item_id：データベースのカラム名
         $item_id：コントローラーのメソッドで引数として渡される変数。渡された特定のアイテムIDの値が入ってる。*/

        return view('detail', compact('item', 'product_category'));
    }

    
    /*（仮）マイページ（プロフィール画面）*/
    public function mypage(Request $request){
        dd('test');
        $user = $request->user();
        return view('profile', compact('user'));
    }


    /*（仮）商品出品画面を出力*/
    public function sell(){
        $categories = Category::all();
        $statuses = Status::all();
        return view('sell', compact('statuses', 'categories'));
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
