<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'user_id',
    ];

    public function hasLikes(Product $product){
        return $this->likes()->where('product_id', $product->id)->exists();
    }
}
