<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request){
        $user = Auth::user();
        $address = $user->address ?? new \App\Models\Address();

        return view('Profile.edit',compact('user','address'));
    }

    public function show(Request $request){
        $user = Auth::user();
        $page = $request->input('page' ,'sell');//リクエストからタブを取り出しなければsellを使う

        $listedProduct = $user->products()->latest()->get();
        //userが出品した商品を新しい順で取得しlistedproductへ代入

        $purchasedProduct = $user->purchasedProducts()->latest()->get();

        $purchasedProduct = $user->orders()
        ->with('product')
        ->latest()
        ->get()
        ->pluck('product')
        ->filter(fn($product) => $product && $product->isSold())
        ->unique('id')
        ->values();

        return view('Profile.show',compact('user','page','listedProduct','purchasedProduct'));
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
