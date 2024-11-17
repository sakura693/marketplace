<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
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
    public function index(Request $request){
       
        /*クエリを取得*/
        $page = $request->query('page');

        if ($page === 'mylist'){
            $user = $request->user();
            $likedItemIds = Like::where('user_id', $user->id)->pluck('item_id');
            $items = Item::whereIn('id', $likedItemIds)->get();
        }else{
            $items = Item::all();
        }
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

      /*いいね閲覧機能⇩*/ 
       /*ログインしていないユーザもいいね数を閲覧できる*/
       $isLikedByUser = false;

       /*ログインしてるユーザーが既にいいねをしているか調べる*/
       if(auth()->check()){
            $isLikedByUser = Like::where('user_id', auth()->user()->id)->where('item_id', $item->id)->exists();

       }
       
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

    /*いいね登録・解除*/
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

    /*商品出品画面を出力*/
    public function sell(){
        /*unique('カラム名')で重複を排除*/
        $categories = Category::all()->unique('category');
        $statuses = Status::all();
        return view('sell', compact('statuses', 'categories'));
    }


    /*商品登録*/
    public function register(ExhibitionRequest $request){
        $items = $request->except(['_token', 'category']); /*$request->all()だったけどエラー出るから変更*/

        if($request->hasFile('image')){
            $path = $request->file('image')->store('image', 'public');

            $urlPath = str_replace('public/', '', $path);
            $urlPath = 'storage/' . $urlPath;

            $items['image'] = $urlPath;
        }

        $item = Item::create($items);
        
        $categories = $request->input('category');
        $item->categories()->sync($categories);/*ItemモデルとCategoryモデル(多対多〈belongsToMany〉) を同期する。
        $item: itemモデル
        categories: itemモデルに定義されたリレーション（itemモデルの下に書いたやつが複数形だから複数形なだけ）
        sync($categories): 同期づけるメソッド（今回はcategoryモデルをitemモデルに同期づける）
        */

        return redirect('/');
    }



    

    /*（仮）商品購入画面を出力*/
    public function purchase($item_id){
        /*uniqueで重複を排除*/
        $payment_methods = PaymentMethod::all()->unique('payment_method');

        $item = Item::select('name', 'image', 'price')->find($item_id);

        /*ログイン済みユーザの住所を取得*/
        $user = auth()->user(['postal_code', 'address', 'building']);

        return view('purchase', compact('payment_methods', 'item', 'user'));
    }


    
    
}
