<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
class ReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $order = Order::with('product.user')->findOrFail($orderId);

        $review = new Review();
        $review->order_id = $order->id;
        $review->user_id = auth()->id();
        $review->role = ($order->buyer_id === auth()->id()) ? 'buyer' : 'seller';
        $review->rating = $request->rating;
        $review->save();

        if ($review->role === 'buyer') {
            $user = $order->buyer;
        } else {
            $user = $order->product->user;
        }
        $user->average_rating = Review::where('user_id', $user->id)->avg('rating');

        return redirect('/')->with('success','レビューを送信しました');
    }



}
