@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('content')
    <div class="detail__content">
        <div class="product__image">
            <img src="{{ asset($product->image_path)}}" alt="商品画像">
        </div><!--product__image-->
<!--商品名-->
    <div class="content--right">
            <h1 class="product__name">{{$product->name}}</h1>
                <p class="product__brand_name">{{$product->brand_name}}</p>
                <p class="bland_name">ブランド名</p>
                <p class="product__price">￥{{number_format($product->price) }}(税込)</p>
<!--いいね-->
    <div class="action__button">
        <div class="like__action--button">
            @if(Auth::check())
                <form action="{{ route('like',$product->id) }}" method="post">
                @csrf
                    <button type="submit" class="like-button {{(Auth::user()->hasLikes($product) ? 'liked' : '') }}">
                    ♡
                    </button>
                    <p class="count">{{$product->likes()->count()}}</p>
                </form>
            @endif
        </div><!--like__action--button-->
<!--コメント-->
        <div class="comment__action--button">
            <a href="#comment" class="comment-button">💭</a>
            <p class="count">{{ $product->comments()->count() }}</p>
        </div><!--comment__action--button-->
    </div><!--action__button-->
<!--購入ボタン-->
            <div class="purchase__button">
                @if(!$product->issold())
                    <a href="{{ route('order.create',['id' => $product->id])}}" class="purchase__button-submit">購入手続きへ</a>
                @else
                    <button class="purchase__disabled-submit" type="submit">購入済み</button>
                @endif
            </div><!--purchase__button-->
<!--商品説明-->
        <h2 class="product__explanation">商品説明</h2>
            <p class="detail">{{ $product->description }}</p>
            <p class="detail">{{$product->condition}}</p>
            <p class="detail">購入後、即発送します</p>
<!--商品の情報-->
        <h2 class="product__information">商品の情報</h2>
            <div class="information__row">
                <span class="label">カテゴリー</span>
                @foreach($product->categories as $category)
                    <span class="value">{{ $category->name }}</span>
                @endforeach
            </div><!--information__row-->
            <div class="information__row">
                <span class="label">商品の状態</span>
                <span class="condition">{{$product->condition}}</span>
            </div><!--information__row-->
<!--コメント-->
    <div class="comment__action">
        <form action="{{ route('comment',$product->id)}}" method="post">
            @csrf
            <h2 class="product__comment">
            コメント({{$product->comments()->count()}})
            </h2>
            @foreach ($product->comments as $comment)
                @if($comment->user)
                    <div class="comment__block">
                        <div class="avatar">
                        <img src="{{ asset($comment->user->avatar ? 'storage/' . $comment->user->avatar : 'img/default_avatar.png') }}" alt="アバター" width="40" height="40">
                        <div class="comment--profile">
                            <span>{{ $comment->user->name }}</span>
                        </div>
                        </div><!--avatar-->
                        <div class="comment--text">
                            <span>{{ $comment->body }}</span>
                        </div><!--comment--text-->
                    </div><!--comment__block-->
                @endif
            @endforeach
<!--コメントの内容が入る-->
            <label for="comment">商品へのコメント</label>
            <textarea name="body" id="comment" class="product__comment-space"></textarea>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
                <div class="comment__button">
                @if(!$product->isSold())
                    <button class="comment__button-submit" type="submit">コメントを送信する</button>
                @else
                <button class="comment__not-submit" type="submit" disabled>コメントできません</button>
                @endif
                </div><!--comment__button-->
            </div><!--content--right-->
        </form>
    </div><!--comment__action-->
</div><!--detail__content-->
@endsection

