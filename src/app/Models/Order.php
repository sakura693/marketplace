<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method_id'
    ];

    /*Itemと関連付ける*/
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
