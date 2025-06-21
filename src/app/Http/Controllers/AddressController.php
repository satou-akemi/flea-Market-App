<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Address;

class AddressController extends Controller
{
    public function edit(Request $request){
        $user = Auth::user();
        $productId = $request->query('product_id');
        return view('Address.address',compact('user','productId'));
    }

    public function update(AddressRequest $request){
        $user = Auth::user();
        $form = $request->all();

        $productId = $request->input('product_id');

        if (empty($productId)) {
            return redirect()->route('mypage')->with('error', '商品情報が見つかりませんでした。');
        }

        if(!$user->address){
            $user->address()->create($form);
        }else{
            $user->address->fill($form)->save();
        }
        return redirect()->route('order.create',['id' => $productId]);
    }
}
