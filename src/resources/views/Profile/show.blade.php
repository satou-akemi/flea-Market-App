@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css')}}">
@endsection

@section('content')
<div class="profile__content">
    <div class="image-space">
        <div class="user__image">
            <img class="avatar-image" src="{{ asset($user->avatar ?'storage/' . $user->avatar :'img/default_avatar.png')}}" alt="avatar.jpg">
        </div><!--user__image-->
            <div class="user-info">
                <h2 class="user_name">{{ $user->name }}</h2>
                <div class="user-rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $user->average_rating)
                        <span class="star-filled">★</span>
                    @else
                        <span class="star">★</span>
                    @endif
                @endfor
                </div>
            </div><!--user-info-->
        <div class="edit-link">
            <a href="/mypage/profile" class="edit-link__button">プロフィールを編集</a>
        </div><!--edit-link-->
    </div><!--image-space-->


<!--切り替えタグ-->
<!--出品した商品-->
    <div class="tab-list">
        <ul class="tab-item">
            <li class="{{$page === 'sell' ? 'active ' : '' }}">
                <a href="{{ route('mypage',['page' => 'sell'])}}">出品した商品</a>
            </li>
<!--購入した商品-->
            <li class="{{ $page === 'buy' ? 'active' : '' }}">
                <a href="{{ route('mypage' , ['page' => 'buy']) }}">購入した商品</a>
            </li>
<!--取引中-->
            <li class="{{ $page === 'deal' ? 'active' : ''}}"><a href="{{ route('mypage'  , ['page' => 'deal'])}}">取引中
                @foreach($deal as $order)
                    <span>{{ $order->messages->count() }}</span>
                @endforeach
            </a>
            </li>
        </ul>
    </div><!--tab-list-->
<!--商品一覧-->
    <div class="product-list">
        @if($page === 'sell')
            @foreach($listedProduct as $product)
            <div class="product" style="position:relative;">
<!--sold-->
                @if($product->isSold())
                    <span class="sold-label" style="position:absolute; top:8px; left:8px; background:#f00; color:#fff; padding:2px 6px; font-size:12px; border-radius:4px; ">SOLD</span>
                @endif
                <img src="{{$product->image_path}}" alt="商品画像">
                <p>{{$product->name}}</p>
            </div><!--product-->
            @endforeach
        @elseif($page === 'buy')
            @foreach($purchasedProduct as $product)
                <div class="product" style="position:relative;">
                    @if($product->isSold())
                        <span class="sold-label" style="position:absolute; top:8px; left:8px; background:#f00; color:#fff; padding:2px 6px; font-size:12px; border-radius:4px; ">SOLD</span>
                    @endif
                    <a href="{{ route('product.show',['id' => $product->id])}}">
                        <img src="{{$product->image_path}}" alt="商品画像">
                    </a>
                    <p>{{$product->name}}</p>
                </div><!--product-->
            @endforeach
        @elseif($page === 'deal')
            @foreach($deal as $order)
                <div class="product">
                    <a href="{{ route('message.show',['id' => $order->id])}}">
                        <img src="{{asset($order->product->image_path) }}" alt="商品画像">
                        <span>{{$order->messages->count()}}
                        </span>
                    </a>
                </div>
            @endforeach
        @endif
    </div><!--product-list-->
</div><!--profile__content-->
@endsection