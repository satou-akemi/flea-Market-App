<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class OrderController extends Controller
{
    public function create($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();
        $payment_methods = ['カード払い', 'コンビニ支払い'];
        $selected_method = null;
        $selected_method = session('selected_method');

        return view('Order.purchase', compact('product', 'user', 'payment_methods', 'selected_method'));
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $product = Product::findOrFail($request->product_id);
        $method = $request->payment_method;

        if ($method === 'カード払い') {
            $stripeMethod = 'card';

            session(['purchased_product_id' => $product->id]);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                'price_data' => [
                'currency' => 'jpy',
                'product_data' =>['name' => $product->name,],
                'unit_amount' => (int) $product->price],
                'quantity' => 1,]],
                'mode' => 'payment',
                'success_url' => route('order.success'),
                'cancel_url' => route('order.cancel'),
            ]);
            return redirect($session->url);
        }
        if ($method === 'コンビニ支払い') {
            session(['purchased_product_id' => $product->id]);

            $session = Session::create([
                'payment_method_types' => ['konbini'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => ['name' => $product->name],
                        'unit_amount' => (int) ($product->price )
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('order.success'),
                'cancel_url' =>route('order.cancel'),
                ]);

                return redirect($session->url);
            }
    }

    public function success(Request $request){
        $productId = session('purchased_product_id');
        $product = Product::find($productId);

        $product->status = 'sold';
        $product->is_sold = 1;
        $product->save();

        Order::create([
            'user_id' => $product->user_id,
            'buyer_id' => auth()->id(),
            'product_id' => $product->id,
            'total_amount' =>
            $product->price,
            'payment_status' => 'paid',
            'order_status' => 'completed',
            'is_dealing' => 1,
            'address_id' => optional(Auth::user()->address)->id,
        ]);
        session()->forget('purchased_product_id');

        return redirect('/')->with('message', '購入が完了しました。');
    }

    public function cancel()
    {
        return redirect('/')->with('error', '支払いがキャンセルされました');
    }

    public function store(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $product->status = 'sold';
    $product->is_sold = 1;
    $product->save();

    Order::create([
        'user_id' => $product->user->id,
        'buyer_id' => auth()->id(),
        'product_id' => $product->id,
        'payment_method' => $request->payment_method,
        'total_amount' => $product->price,
        'payment_status' => 'paid',
        'order_status' => 'completed',
        'is_dealing' => 1,
        'address_id' => optional(Auth::user()->address)->id,
    ]);

    $product->is_sold = true;
    $product->save();

    return redirect()->route('order.create',['id' => $request->product_id])->with('selected_method', $request->payment_method);
}
}
