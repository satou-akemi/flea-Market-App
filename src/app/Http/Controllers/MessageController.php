<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;

class MessageController extends Controller
{
    public function show($id){
        $order = Order::with('product','messages')->findOrFail($id);
        $user = auth()->user();
        $orders = Order::where('user_id',$user->id)->where('id','!=' ,$id)->with('product')->get();

        if($order->buyer_id === auth()->id()){
            $status = 'is_buyer';
        }else{
            $status = 'is_seller';
        }

        return view('Order.message',compact('order','user','status','orders'));
    }

    public function store(Request $request){

    }
}
