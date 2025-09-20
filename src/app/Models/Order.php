<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'order_date',
        'total_amount',
        'payment_status',
        'order_status',
        'address_id',
        'payment_id',
        'payment_method',
        'is_dealing',
    ];


    public function user(){
    return $this->belongsTo(User::class);
    }

    public function product(){
    return $this->belongsTo(Product::class);
    }

    public function messages(){
    return $this->hasMany(Message::class);
    }

    public function reviews(){
    return $this->hasMany(ProductReview::class);
    }

    public function unreadMessagesCount(){
        return $this->messages()->where('is_read',false)->count();
    }

    public function unreadMessagesCountForUser(){
        $user = auth()->user();

        if($user->id === $this->product->user_id){
            return $this->messages()->where('is_read_seller',false)->count();
        }else{
            return $this->messages()->where('is_read_buyer',false)->count();
        }
    }
}
