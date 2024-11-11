<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /*itemsと関連付けてる（中間テーブルでつながれているテーブルのみにこのbelongsToManyを設定する）*/
    public function items(){
        return $this->belongsToMany(Item::class, 'product_categories', 'category_id', 'item_id');
    }
}
