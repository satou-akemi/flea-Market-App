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
        $review->rating = $request->rating;
        $review->save();

        return redirect('/')->with('success','レビューを送信しました');
    }

}
