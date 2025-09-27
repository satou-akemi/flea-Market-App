<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompletionEmail;


class ReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $order = Order::with('product.user')->findOrFail($orderId);

        $review = new Review();
        $review->role = ($order->buyer_id === auth()->id()) ? 'buyer' : 'seller';

        if($review->role == 'seller'){
            $review->user_id = $order->buyer_id;
        }else{
            $review->user_id = $order->product->user_id;
        }

        $review->order_id = $order->id;
        $review->reviewer_id = auth()->id();
        $review->rating = $request->input('rating') ?? $request->input('ratingSeller');
        $review->save();

        if ($review->role === 'buyer') {
            $user = $order->product->user;
        } else {
            $user = $order->buyer;
        }
        Mail::to($user->email)->send(new CompletionEmail());

        return redirect('/')->with('success','レビューを送信しました');
    }

    public function sendEmail($review){
        $review = Review::findOrFail($review);
        $order = $review->order;
        $sellerEmail = $order->product->user->email;
        Mail::to($sellerEmail)->send(new CompletionEmail());
        return redirect()->back();
    }
}
