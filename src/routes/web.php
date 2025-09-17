<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//商品関連
Route::get('/',[ProductController::class,'index'])->name('product.index');
Route::get('/product',[ProductController::class,'index'])->name('products.index');
Route::get('/sell',[ProductController::class,'listing'])->name('product.listing');
Route::post('/sell',
[ProductController::class,'store'])->name('product.store');
//出品
Route::get('/product/{id}',[ProductController::class,'show'])->name('product.show');

//購入
Route::get('/order/create/{id}',[OrderController::class,'create'])->name('order.create');
Route::post('/order/store',[OrderController::class,'store'])->name('order.store');
Route::get('/home', [OrderController::class, 'index'])->name('home');


//送付住所
Route::middleware(['auth'])->group(function () {
Route::get('/address',[AddressController::class,'edit'])->name('address.edit');
//更新ボタン処理
Route::put('/address',[AddressController::class,'update'])->name('address.update');
Route::get('/order/purchase/{id}', [OrderController::class, 'purchase'])->name('order.purchase');
});

//認証関連
//Route::get('/register', [AuthController::class, 'store'])->name('store');
Route::post('/register', [RegisterController::class, 'store'])->name('store');
Route::get('/thanks', function () {
return view('thanks');
})->name('thanks');



//プロフィール関連
Route::middleware(['auth','verified'])->group(function () {
Route::get('/setup',[ProfileController::class,'setup'])->name('profile.setup');//setup入るとき->withoutMiddleware(['auth']);
Route::post('/update',[ProfileController::class,'update'])->name('profile.setup.update');
Route::get('/mypage/profile',[ProfileController::class,'edit'])->name('profile.edit');
Route::get('/mypage',[ProfileController::class,'show'])->name('mypage');//
Route::put('/mypage/profile',[ProfileController::class,'update'])->name('profile.update');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

//アドレス認証
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
return redirect('/setup');
})->middleware(['auth', 'signed'])->name('verification.verify');

//いいねコメント機能
Route::post('/like/{id}',[LikeController::class,'store'])->name('like');
Route::get('/like/{id}', [LikeController::class, 'show']);
Route::post('/comment/{id}',[CommentController::class,'store'])->name('comment')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/order/{id}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    Route::get('/message/{id}',[MessageController::class,'show'])->name('message.show');
    Route::post('/message/{id}',[MessageController::class,'show'])->name('message.store');
});
