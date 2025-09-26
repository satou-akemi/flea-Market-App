<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;

class MessageController extends Controller
{
    public function show(Request $request,$id){
        $order = Order::with('product','messages')->findOrFail($id);
        $user = auth()->user();

        // メッセージ既読処理
        if($user->id === $order->product->user_id){
            $order->messages()->where('is_read_seller',false)->update(['is_read_seller' => true]);
        }else{
            $order->messages()->where('is_read_buyer',false)->update(['is_read_buyer' => true]);
        }

        // メッセージ取得
        $messages = Message::where('order_id',$order->id)->with('user')->orderBy('created_at')->get();

        if($order->buyer_id === auth()->id()){
            $status = 'is_buyer';
            $client = $order->product->user;
        }else{
            $status = 'is_seller';
            $client = $order->buyer;
        }

        //その他の商品取得
        $currentOrderIds = $order->id;
        $deal = $user->currentDeals()->where('id','!=',$currentOrderIds);

        // レビュー判定
        $reviewedByBuyer = Review::where('order_id',$order->id)->where('role','buyer')->exists();

        $reviewedSeller = Review::where('order_id',$order->id)->where('role','seller')->exists();

        $draft = $request->session()->get('message_text_'.$id, '');

        return view('Order.message',compact('order','user','status','client','messages','order','reviewedByBuyer','reviewedSeller','currentOrderIds','deal','draft'));
    }

    public function saveDraft(Request $request, $id){
        // order_idごとにセッション保存
        $request->session()->put('message_text_'.$id, $request->input('message_text'));

        return response()->json(['success' => true]);
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
        $request->session()->forget('message_text_' . $id);

        return redirect()->back();
    }

    public function edit($id){
        $message = Message::findOrFail($id);

        return view('messages.edit',compact('message'));
    }

    public function update(Request $request,$id){
        $message = Message::findOrFail($id);
        $message->message_text = $request->message_text;
        $message->save();

        return redirect()->route('message.show',['id'=> $message->order_id])->with('success','メッセージを更新しました');
    }


    public function destroy($id){

        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success','メッセージを削除しました');
    }
}
