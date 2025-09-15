<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;

class LikeController extends Controller
{
    public function store($id)
{
    $user = auth()->user();
    // いいねがまだなければ追加
    if ($user->likes()->where('product_id', $id)->exists()) {
        $user->likes()->detach($id);
    }else {
        $user->likes()->attach($id);
    }
    return redirect()->back();
}
//exists():存在するか確認

public function show($id)
{
    $user = auth()->user();
    $product = Product::findOrFail($id);
    $liked = $user->likes()->where('product_id', $id)->exists();

    return view('Product.detail', compact('product','liked'));
}
}
