<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /*categoriesと関連付けてる（中間テーブルでつながれているテーブルのみにこのbelongsToManyを設定する）*/
    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories', 'item_id', 'category_id');
    }

    /*statusesテーブルと関連付けている*/
    public function statuses(){
        return $this->belongsToMany(Status::class, 'product_statuses', 'item_id', 'status_id');
    }
}

