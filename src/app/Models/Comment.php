<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'comment' 
    ];

    /*Userモデルと関連付ける（commentsテーブルはuser_id〈外部キー〉を持つから）*/
    public function user(){
        return $this ->belongsTo(User::class);
    }
}
