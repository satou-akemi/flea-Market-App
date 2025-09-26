<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{
    public function edit(Request $request){
        $user = Auth::user();
        $address = $user->address ?? new \App\Models\Address();

        return view('Profile.edit',compact('user','address'));
    }

    public function show(Request $request){
    $user = Auth::user();
    $page = $request->input('page', 'sell');

    // 出品した商品
    $listedProduct = $user->products()->latest()->get();

    $purchasedProduct = [];
    $purchasedProductIds = [];

    // 購入した商品（購入済み）
    $ordersAsBuyer = Order::where('buyer_id', $user->id)
        ->with('product')
        ->latest()
        ->get();

    foreach ($ordersAsBuyer as $order) {
    $product = $order->product;
    if ($product) {
        if ($product->isSold()) {
            $alreadyAdded = false;
            foreach ($purchasedProductIds as $addedId) {
                if ($addedId == $product->id) {
                    $alreadyAdded = true;
                    break;
                }
            }
            // 追加されていなければ配列に追加
            if ($alreadyAdded == false) {
                $purchasedProduct[] = $product;
                $purchasedProductIds[] = $product->id;
            }
        }
    }
}

    // 取引中の商品
    $deal = Order::where(function($query) use ($user){
            $query->where('user_id', $user->id)
                ->orWhere('buyer_id', $user->id);
        })
        ->where('is_dealing', 1)
        ->with('product', 'messages')
        ->get();

    // メッセージの最新日時でソート
    $deal = $deal->sortByDesc(function($order){
        $latest = $order->messages->last();
        return $latest ? $latest->created_at : null;
    });

    return view('Profile.show', compact('user', 'page', 'listedProduct', 'purchasedProduct', 'deal'));
}

    public function __construct(){
        $this->middleware('auth');
        //何度も定義不要
    }

    public function setup(){
        $user = Auth::user();
        //$user = User::find(1);
        //Auth::login($user);//あとで上と変える
        return view('Profile.setup',compact('user'));
    }

    public function update(ProfileRequest $request){
        $user = Auth::user();
        //リクエストから受け取ったユーザー情報
        //$user->user_name = $request->input('user_name');
        $user->name = $request->input('name') ?? $user->name;

        //アバターがアップロードされた場合の処理
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatar','public');
            $user->avatar = $path;
        }
        $user->save();
        //ユーザ情報をデータベースへ保存

        $address = $user->address;
        if(!$address){
            //初めての住所登録
            $address = new \App\Models\Address();
            $address->user_id = $user->id;
        }
        $address->postal_code =$request->input('postal_code');
        $address->prefecture = $request->input('prefecture');
        $address->city = $request->input('city');
        $address->street = $request->input('street');
        $address->building = $request->input('building');
        $address->save();

        return redirect('/');
    }
}
