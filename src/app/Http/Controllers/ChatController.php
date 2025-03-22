<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Item; 
use App\Models\User; 
use App\Models\Order; 
use App\Models\Chat; 
use App\Http\Requests\MessageRequest; 

class ChatController extends Controller
{
    /*（仮）チャット画面を取得*/
    public function chat($item_id){
        $user = auth()->user(); //ログインユーザー

        $item = Item::with('user')->findOrFail($item_id); //item情報とuser情報を取得

        $order = Order::where('item_id', $item_id)->first();

        //ログインユーザーが出品者なら購入者の名前を、購入者なら出品者の名前を表示
        $partner = ($user->id === $item->user_id) ? $order->user : $item->user;
        
        $chats = Chat::where('order_id', $order->id)->with('user')->orderBy('created_at', 'asc')->get();

        $editId = request()->query('edit');
        $editMessage = null;

        if ($editId){
            $editMessage = Chat::find($editId);
        }

        return view('chat', compact('item', 'user', 'partner', 'chats', 'editMessage'));
    }

    /*メッセージの送信*/
    public function storeMessage(MessageRequest $request, $item_id){
        $order = Order::where('item_id', $item_id)->where(function ($query){
            $query->where('user_id', auth()->id())
                  ->orWhereHas('item', function($q){
                    $q->where('user_id', auth()->id());
                  });
        })->firstOrFail();
        
        $chat = Chat::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('image', 'public');
            $urlPath = str_replace('public/', '', $path);
            $urlPath = 'storage/' . $urlPath;

            $chat->image = $urlPath;
        }
        $chat->save();

        return redirect()->back();
    }

    public function destroy(Chat $chat){
        $chat->delete();
        return redirect()->back();
    }

    public function update(Request $request, Chat $chat){
        $chat->message = $request->message;
        $chat->save();
        return redirect()->back();
    }

    /*評価保存機能*/
    public function storeRating(Request $request, $item_id){
        $user = auth()->user();

        $order = Order::where('item_id', $item_id)->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)->orWhereHas('item', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });})->first();

        if ($order->item->user_id === $user->id) {
            $order->seller_rating = $request->rating;
        } elseif ($order->user_id === $user->id) {
            $order->buyer_rating = $request->rating;
        } 

        if ($order->buyer_rating !== null && $order->seller_rating !== null) {
            $order->item->sold = 2;
            $order->item->save();
        }

        $order->save();
        return redirect()->to("/");
    }
}
