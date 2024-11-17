<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'status_id'
    ];

    /*categoriesと関連付けてる（中間テーブルでつながれているテーブルのみにこのbelongsToManyを設定する）*/
    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories', 'item_id', 'category_id');
    }

    /*Statusのリレーションを追加（一対多）*/
    public function status(){
        return $this->belongsTo(Status::class);
    }

    /*likesと関連付ける（itemとlikeは一対多）*/
    public function likes(){
        return $this->hasMany(Like::class);
    }
}

