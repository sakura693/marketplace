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
use App\Models\Like; /*追加*/


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
       }, 'status'])->findOrFail($item_id);

       /*コメント数を表示*/
       $comments = Comment::with('user')->where('item_id', $item->id)->get();
       $commentCount = $comments->count();

       /*よう分らん笑*/
       $isLikedByUser = Like::where('user_id', auth()->user()->id)->where('item_id', $item->id)->exists();

       /*いいね数を表示*/
       $likeCount = $item->likes()->count();

       return view('detail', compact('item', 'comments', 'commentCount', 'isLikedByUser', 'likeCount'));
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


    /*（仮）商品購入画面を出力*/
    public function purchase($item_id){
        $payment_methods = PaymentMethod::all();

        $item = Item::select('name', 'image', 'price')->find($item_id);

        return view('purchase', compact('payment_methods', 'item'));
    }





    /*（仮）いいね登録・解除*/
    public function toggleLike($item_id){
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)->where('item_id', $item_id)->first();
        if ($like){
            $like->delete(); /*既にいいねがあるなら削除*/
        }else{ /*いいねない場合は新規作成*/
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item_id,
            ]);
        }
        return back();
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

     /*（仮）プロフィール編集画面を出力*/
    public function address(){
        return view('address');
    }


    
    
}
