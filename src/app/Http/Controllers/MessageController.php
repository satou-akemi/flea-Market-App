<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;

class MessageController extends Controller
{
    public function show(Request $request,$id){
        $order = Order::with('product','messages')->findOrFail($id);

        $user = auth()->user();

        if($user->id === $order->product->user_id){
            $order->messages()->where('is_read_seller',false)->update(['is_read_seller' => true]);
        }else{
            $order->messages()->where('is_read_buyer',false)->update(['is_read_buyer' => true]);
        }

        $orders = Order::where('user_id',$user->id)->where('id','!=' ,$id)->with('product')->get();

        $messages = Message::where('order_id',$order->id)->with('user')->orderBy('created_at')->get();

        if($order->user_id === auth()->id()){
            $status = 'is_buyer';
            $client = $order->product->user;
        }else{
            $status = 'is_seller';
            $client = $order->user;
        }

        return view('Order.message',compact('order','user','status','orders','client','messages','order'));
    }

    public function store(MessageRequest $request,$id){
        $order = Order::findOrFail($id);
        $message = new Message();
        $message->user_id = auth()->id();
        $message->order_id = $order->id;
        $message->message_text = $request->input('message_text');

        if($request->hasFile('add-image')){
        $path = $request->file('add-image')->store('messages','public');
        $message->image_path = $path;
        }
        $message->save();

        return redirect()->back();
    }

    public function edit($id){
        $message = Message::findOrFail($id);

        return view('messages.edit',compact('message'));

    }

    public function destroy($id){

        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success','メッセージを削除しました');
    }
}
