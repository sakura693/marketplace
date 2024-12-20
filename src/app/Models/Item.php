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
        'status_id',
        'user_id',
        'sold'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories', 'item_id', 'category_id');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)){
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}

