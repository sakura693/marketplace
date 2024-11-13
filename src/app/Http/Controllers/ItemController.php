<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CommentRequest;
use App\Models\User; /*追加*/
use App\Models\Status; /*追加*/
use App\Models\Category; /*追加*/
use App\Models\PaymentMethod; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\ProductCategory; /*追加*/
use App\Models\ProductStatus; /*追加*/
use App\Models\Comment; /*追加*/


class ItemController extends Controller
{
    
     /*商品一覧画面を出力*/
    public function index(){
        $items = Item::all();
        return view('item', compact('items'));
    }

    /*商品詳細画面を出力*/
    public function show($item_id){
        /*distinctでカテゴリの重複を排除*/
       $item = Item::with(['categories' => function($query){
        $query->distinct();
       }, 'statuses'])->findOrFail($item_id);

       /*コメント数を表示*/
       $comments = Comment::where('item_id', $item->id)->get();
       $commentCount = $comments->count();

       return view('detail', compact('item', 'commentCount'));
    }

    /*コメントを保存*/
    public function store(CommentRequest $request, $item_id){
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'comment' => $request->comment,
        ]);
        return back(); /*元のページに戻る*/
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
