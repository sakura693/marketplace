<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    public function items(){
        return $this->belongsToMany(Item::class, 'product_categories', 'category_id', 'item_id');
    }
}

