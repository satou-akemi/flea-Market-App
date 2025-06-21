<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Comment;

class ProductController extends Controller
{
    public function index(Request $request){
        $tab = $request->query('tab','recommend');
        //urlにtabがあればその値を$tabに代入
        // なければrecommendが代入
        $userId = Auth::id();
        $keyword = $request->input('keyword');

        $products = collect();
        $recommendedProducts = collect();
        $myListProducts = collect();

    if ($keyword) {
        // キーワード検索
        $products = Product::where('user_id', '!=', $userId)
        ->where('name', 'like', '%' . $keyword . '%')
        ->get();
    } else {
        // タブ切り替え
    if ($tab === 'recommend') {
        $recommendedProducts = Product::where('is_recommended', true)
        ->where('user_id', '!=', $userId)
        ->get();
    } elseif ($tab === 'mylist') {
        $myListProducts = Auth::check() ? Auth::user()->likes()->get() : collect();
        //お気に入りリストを取得そうでない場合、空のリストを用意してエラー回避
        }
    }
        return view('Product.index', compact('products','tab', 'recommendedProducts', 'myListProducts','keyword'));
    }

    public function show($id){
        $product = Product::with(['comments.user','categories'])->findOrFail($id);//N+1問題
        return view('Product.detail',compact('product'));
    }

    public function listing(Request $request){
        $categories = Category::all();
        $categoryIds = $request->input('category_ids');

        return view('Product.listing',compact('categories'));
    }

    public function store(ExhibitionRequest $request){
        $product = new Product();
        $product->name =$request->input('name');
        $product->brand_name = $request->input('brand_name');
        $product->description = $request->input('description');
        $product->price =$request->input('price');
        $product->condition = $request->input('condition');
        $product->user_id = Auth::id();
        //ログインしてるユーザID

        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('products','public');
            $product->image_path = 'storage/' . $path;
            //画像保存先までのパス
        }
        $product->save();
        $product->categories()->sync($request->input('category_ids',[]));

        return redirect()->route('product.index');
    }

}
