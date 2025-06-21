@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}"/>
@endsection

@section('content')
<div class="product-index">
    <div class="tab-button">
        <ul class="tab__items">
<!--おすすめ-->
            <li class="{{ $tab === 'recommend' ? 'active tab-recommend' : '' }}">
                <a href="{{ route('product.index', ['tab' => 'recommend']) }}">おすすめ</a>
            </li>
<!--マイリスト-->
            <li class="{{ $tab === 'mylist' ? 'active tab-mylist' : '' }}">
                <a href="{{ route('product.index' , ['tab' => 'mylist', 'keyword' => request('keyword')]) }}">マイリスト</a>
            </li>
        </ul>
    </div><!--tab-buttons-->
    <div class="product-list">
    @if(request('keyword'))
    @foreach($products as $product)
        <div class="product" style="position:relative;">
            @if($product->isSold())
                <span class="sold-label" style="position:absolute; top:8px; left:8px; background:#f00; color:#fff; padding:2px 6px; font-size:12px; border-radius:4px;">SOLD</span>
            @endif
            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                <img src="{{ $product->image_path }}" alt="商品画像">
                <p>{{ $product->name }}</p>
            </a>
        </div>
    @endforeach
@else
    <!-- 通常のおすすめ / マイリスト -->
    @if($tab === 'mylist')
        @foreach($myListProducts as $product)
            <div class="product" style="position:relative;">
                @if($product->isSold())
                    <span class="sold-label" style="position:absolute; top:8px; left:8px; background:#f00; color:#fff; padding:2px 6px; font-size:12px; border-radius:4px;">SOLD</span>
                @endif
                <a href="{{ route('product.show',['id' => $product->id])}}">
                    <img src="{{ $product->image_path }}" alt="商品画像">
                    <p>{{ $product->name}}</p>
                </a>
            </div>
        @endforeach
    @elseif($tab === 'recommend')
        @foreach($recommendedProducts as $product)
            <div class="product" style="position:relative;">
                @if($product->isSold())
                    <span class="sold-label" style="position:absolute; top:8px; left:8px; background:#f00; color:#fff; padding:2px 6px; font-size:12px; border-radius:4px;">SOLD</span>
                @endif
                <a href="{{ route('product.show',['id' => $product->id])}}">
                    <img src="{{ $product->image_path }}" alt="商品画像">
                    <p>{{ $product->name}}</p>
                </a>
            </div>
        @endforeach
    @endif
@endif
</div><!--product-list-->
    </div><!--product-list-->
</div><!--product-index-->

@endsection
