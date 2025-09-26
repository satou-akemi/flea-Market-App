<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'rating',
        'role',
        'reviewer_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function message(){
        return $this->belongsTo(Message::class);
    }

    public function reviewer(){
        return $this->belongsTo(User::class,'reviewer_id');
    }
}
