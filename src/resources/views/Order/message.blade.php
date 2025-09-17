@extends('layouts.default')
@section('css')
<link rel="stylesheet" href="{{asset('css/message.css')}}">
@endsection

@section('content')
<aside>
    <div class="others-deal">その他の取引</div>
    @foreach($orders as $otherOrder)
        <div class="dealing">{{$otherOrder->product->name}}</div>
    @endforeach
</aside>

<form action="{{ route('message.store',['id' => $order->id])}}" method="POST" class="message-content" enctype="multipart/form-data">
    @csrf
    @if($status === 'is_buyer')
    <div class="deal-header">
        <div class="buyer-user-img">
            <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg" class="user-avatar">
        </div>
            <h1 class="deal-title">「{{$order->user->name}}」さんとの取引画面</h1>
            <a href="/">取引を終了する</a>
    </div><!--deal-header-->
    <div class="product-information">
        <img src="{{asset($order->product->image_path)}}" alt="商品画像">
        <h2 class="product-name">{{$order->product->name}}</h2>
        <p class="product-price">{{$order->product->price}}</p>
    </div>
    <div class="chat-message">
        <div class="buyer-user-img">
            <img src="{{asset($user->avatar ? 'storage/' .$user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg" class="user-name">
        </div>
            <p class="user-name">{{$order->user->name}}</p>
            <textarea name="message" id="message"></textarea>
    </div>
    @elseif($status === 'is_seller')
    <div class="deal-header">
        <div class="seller-user-img">
            <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg" class="user-avatar">
        </div>
            <h1 class="deal-title">「{{$order->user->name}}」さんとの取引画面</h1>
    </div><!--deal-header-->
    <div class="product-information">
        <div class="chat-user-img">
            <img src="{{asset($order->product->image_path)}}" alt="商品画像">
        </div>
            <h2 class="product-name">{{$order->product->name}}</h2>
            <p class="product-price">￥{{number_format($order->product->price)}}(税込み)</p>
        </div>
    </div>
    <div class="chat-message">
        <div class="buyer-user-img">
            <img src="{{asset($user->avatar ? 'storage/' .$user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg" class="user-name">
        </div>
            <p class="user-name">{{$order->user->name}}</p>
            <textarea name="message" id="message"></textarea>
        </div>
    @endif
    <div class="message-form">
        <input type="text" name="deal-message" placeholder="取引メッセージを記入してください">
        <label for="file-input">画像を追加</label>
        <input type="file" name="add-image" id="file-input" hidden>
        <button type="submit"><img src="{{asset('img/send.jpg')}}" alt="" class="send-img"></button>
    </div>
</form>
@endsection