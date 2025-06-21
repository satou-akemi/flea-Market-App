@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
<form action="{{ route('order.checkout') }}" method="POST">
@csrf
<div class="purchase__content">
    <div class="purchase-left">
        <div class="product">
            <div class="product__image">
                <img src="{{ asset($product->image_path)}}" alt="商品画像">
            </div><!--product__image-->
        <div class="product__info">
            <h2 class="product__name">{{$product->name}}</h2>
            <p class="price">￥{{number_format($product->price)}}</p>
        </div><!--product__info-->
    </div><!--product-->
<!--支払い-->
        <input type="hidden" name="product_id" value="{{ $product->id}}">
        <div class="payment">
            <h3 class="payment__method">支払い方法</h3>
            <select name="payment_method" class="payment__method--select">
            <option value="" disabled {{ is_null($selected_method) ? 'selected' : '' }}>選択してください</option>
                @foreach($payment_methods as $method)
                    <option value="{{ $method}}" {{ $method === $selected_method ? 'selected' : ''}}>{{$method}}</option>
                @endforeach
            </select>
            @error('payment_method')
                <div class="error">{{ $message}}</div>
            @enderror
        </div><!--payment-->
<!--配送先-->
        <div class="address">
            <div class="address__row">
                <h3 class="shopping_address">配送先</h3>
                <div class="edit-address">
                    <a href="{{route('address.edit', ['product_id' => $product->id]) }}">変更する</a>
                </div><!--edit-address-->
            </div><!--address__row-->
                <div class="existing__address">
                    @if($user && $user->address)
                        <p>〒{{$user->address->postal_code}}</p>
                        <p>
                        {{$user->address->prefecture}}{{$user->address->city}}{{$user->address->street}}
                    @if($user->address->building)
                    {{$user->address->building}}
                    @endif
                        </p>
                    @else
                        <p>住所情報が登録されていません。</p>
                    @endif
                </div><!--exiting__address-->
            </div><!--address-->
    </div><!--purchase-left-->
        <div class="purchase-right">
            <div class="checkout">
                <table class="price-table">
                    <tr class="table-row">
                        <td class="table-cell">
                        商品代金
                        </td>
                        <td class="table-cell">
                        ￥{{number_format($product->price)}}
                        </td>
                    </tr>
                    <tr class="table-row">
                        <td class="table-cell">
                        支払方法
                        </td>
                        <td class="table-cell">{{ old('payment_method', $selected_method) }}</td>
                    </tr>
                </table>
        </div><!--payment-->
            <div class="purchase__button">
                <button type="submit" class="purchase__button-submit">購入する</button>
            </div><!--purchase__button-->
        </div><!--purchase--right-->
    </form>
</div><!--purchase__content-->
@endsection