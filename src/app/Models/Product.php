<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'image_path',
        'condition',
        'user_id',
        'is_sold',
        'is_recommended',
        'brand_name',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function isSold(){
        return $this->is_sold == 1 || $this->status === 'sold';
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes', 'product_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
