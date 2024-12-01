<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\User; 
use App\Models\Status; 
use App\Models\Category; 
use App\Models\PaymentMethod; 
use App\Models\Item; 
use App\Models\ProductCategory; 
use App\Models\ProductStatus;
use App\Models\Comment; 
use App\Models\Like; 
use App\Models\Order; 


class ItemController extends Controller
{
    public function index(Request $request){
        $tab = $request->query('tab');
        $user = $request->user();

        if ($tab === 'mylist'){
            if($user){
                $user = $request->user();
                $likedItemIds = Like::where('user_id', $user->id)->pluck('item_id');
                $items = Item::whereIn('id', $likedItemIds)->get();
            }else {
                $items = collect();
            }
        }else {
            if ($user){
                $items = Item::where(function ($query) use ($user) {
                    $query->where('user_id', '!=', $user->id)->orWhereNull('user_id');
                })->get();
            }else{
                $items = Item::all();
            }
        }

        return view('item', compact('items'));
    }

    public function show($item_id){
       $item = Item::with(['categories' => function($query){
        $query->distinct();
       }, 'status'])->findOrFail($item_id);

       $comments = Comment::with('user')->where('item_id', $item->id)->get();
       $commentCount = $comments->count();

       $isLikedByUser = false;

       if(auth()->check()){
            $isLikedByUser = Like::where('user_id', auth()->user()->id)->where('item_id', $item->id)->exists();

       }
       
       $likeCount = $item->likes()->count();

       return view('detail', compact('item', 'comments', 'commentCount', 'isLikedByUser', 'likeCount'));
    }

    public function store(CommentRequest $request, $item_id){
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'comment' => $request->comment,
        ]);
        return back(); 
    }

    public function toggleLike($item_id){
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)->where('item_id', $item_id)->first();
        if ($like){
            $like->delete(); 
        }else{ 
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item_id,
            ]);
        }
        return back();
    }

    public function sell(){
        $categories = Category::all()->unique('category');
        $statuses = Status::all();
        return view('sell', compact('statuses', 'categories'));
    }

    public function register(ExhibitionRequest $request){
        $items = $request->except(['_token', 'category']);

        $items['user_id'] = auth()->id();

        if($request->hasFile('image')){
            $path = $request->file('image')->store('image', 'public');

            $urlPath = str_replace('public/', '', $path);
            $urlPath = 'storage/' . $urlPath;

            $items['image'] = $urlPath;
        }

        $item = Item::create($items);
        
        $categories = $request->input('category');
        $item->categories()->sync($categories);

        return redirect('/');
    }


    public function search(Request $request){
        $keyword = $request->input('keyword');
        $items = Item::KeywordSearch($keyword)->get();  

        return view('item', compact('items'));
    }


    public function purchase($item_id){

        $item = Item::select('id', 'name', 'image', 'price')->find($item_id);

        $user = auth()->user(['postal_code', 'address', 'building']);

        $payment_methods = PaymentMethod::all()->unique('payment_method');

        return view('purchase', compact('payment_methods', 'item', 'user'));
    }    
}
