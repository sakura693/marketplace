<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Item; 
use App\Models\User; 
use App\Models\Order; 
use App\Models\Chat; 
use App\Http\Requests\MessageRequest; 
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompletion;

class ChatController extends Controller
{
    public function chat($item_id){
        $user = auth()->user();
        $item = Item::with('user')->findOrFail($item_id); 
        $order = Order::where('item_id', $item_id)->first();
        $partner = ($user->id === $item->user_id) ? $order->user : $item->user;        
        $chats = Chat::where('order_id', $order->id)->with('user')->orderBy('created_at', 'asc')->get();

        Chat::where('order_id', $order->id)
        ->where('user_id', '!=', $user->id)  
        ->where('is_read', false)
        ->update(['is_read' => true]);

        $editId = request()->query('edit');
        $editMessage = null;

        if ($editId){
            $editMessage = Chat::find($editId);
        }

        $otherItems = Item::where('sold', 1)
        ->where('id', '!=', $item_id)
        ->where(function($query) use ($user){
            $query->where('user_id', $user->id)
            ->orWhereHas('order', function($q) use ($user){
                $q->where('user_id', $user->id);
            });
        })->get();

        return view('chat', compact('item', 'user', 'partner', 'chats', 'editMessage', 'otherItems'));
    }

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

        $receiver = ($order->user_id === auth()->id()) ? $order->item->user : $order->user;

        $chat->is_read = false;  
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

    public function storeRating(Request $request, $item_id){
        $user = auth()->user();

        $order = Order::where('item_id', $item_id)->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)->orWhereHas('item', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });})->first();

        if ($order->item->user_id === $user->id) {
            if($order->buyer_rating !== null){
                $order->seller_rating = $request->rating;
            }else{
               return redirect()->back(); 
            }
        } elseif ($order->user_id === $user->id) {
            $order->buyer_rating = $request->rating;
        } 

        if ($order->buyer_rating !== null && $order->seller_rating !== null) {
            $order->item->sold = 2;
            $order->item->save();
        }

        $order->save();

        if ($order->item->sold == '2') {
            Mail::to($order->user->email)->send(new TransactionCompletion($order));
        }
        return redirect()->to("/");
    }
}
