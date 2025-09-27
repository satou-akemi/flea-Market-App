<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;//こことclassの部分消すと無効にできる
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;

class User extends Authenticatable implements MustVerifyEmail//ここ
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_name',
        'email',
        'billing_address_prefecture',
        'billing_address_city',
        'billing_address_street',
        'billing_address_postal_code',
        'avatar',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function likes(){
        return $this->belongsToMany(Product::class, 'likes', 'user_id', 'product_id');
    }

    public function hasLikes(Product $product){
        return $this->likes()->where('product_id',$product->id)->exists();//表示している商品IDがあるか調べる
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function orders(){
    return $this->hasMany(Order::class,);
    }

    public function purchasedProducts(){
    // ordersテーブル経由で購入したproductを取得
    return $this->hasManyThrough(Product::class, Order::class, 'user_id', 'id', 'id', 'product_id');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class,'user_id');
    }

    public function averageRating(){
        return round($this->reviews()->avg('rating'));
    }

    public function ordersAsBuyer(){
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function currentDeals(){
        // 購入者としての取引
        $dealAsBuyer = $this->ordersAsBuyer()->where('is_dealing',true)->with('product','messages')->get();

        // 出品者としての取引
        $sellerProductIds = $this->products()->pluck('id');
        $dealAsSeller = Order::whereIn('product_id',$sellerProductIds)->where('is_dealing',true)->with('product','messages')->get();

        return $dealAsBuyer->merge($dealAsSeller);
    }

    public function Reviewer(){
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
