@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css')}}">
@endsection

@section('font')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="listing__content">
        <h1 class="listing__ttl">商品の出品</h1>
    <form action="{{ route('product.store')}}" method="post" enctype="multipart/form-data">
    @csrf
<!--商品画像-->
        <label class="description-text">商品画像</label>
    <div class="product__img">
        <label for="image_path" class="image-upload-button">画像を選択する</label>
            <input type="file" name="image_path" id="image_path"  style="display:none;">
        @error('image_path')
            <div class="error">{{$message}}</div>
        @enderror
    </div><!--product__img-->

<!--詳細タイトル-->
        <h3 class="product-detail">商品の詳細</h3>

<!--カテゴリー-->
    <div class="category__list">
    <label class="description-text">カテゴリー</label>
        @foreach($categories as $category)
            <label>
                <input type="checkbox" name="category_ids[]" value="{{$category->id}}">
                <span>{{$category->name}}</span>
            </label>
        @endforeach
        @error('category_ids')
            <div class="error">{{$message}}</div>
        @enderror
    </div><!--category--__list-->

<!--商品の状態-->
    <div class="select-wrapper">
    <label class="description-text">商品の状態</label>
        <select name="condition" id="condition">
            <option value="" disabled selected>選択してください</option>

            <option value="良好">良好</option>

            <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>

            <option value="やや傷や汚れあり">やや傷や汚れあり</option>

            <option value="状態が悪い">状態が悪い</option>
        </select>
        @error('condition')
            <div class="error">{{$message}}</div>
        @enderror
    </div><!--select-wrapper-->

<!--商品名と説明-->
        <h3 class="product-detail">商品名と説明</h3>
            <div class="description__group">
                <label class="description-text">商品名</label>
                    <input type="text" name="name">
                @error('name')
                    <div class="error">{{$message}}</div>
                @enderror
            </div><!--description__group-->
            <div class="description__group">
                <label class="description-text">ブランド名</label>
                    <input type="text" name="brand_name">
                @error('brand_name')
                    <div class="error">{{$message}}</div>
                @enderror
            <!--description__group-->
            <div class="description__group">
                <label class="description-text">商品の説明</label>
                    <textarea name="description"></textarea>
                @error('description')
                    <div class="error">{{$message}}</div>
                @enderror
            </div><!--description__group-->
            <div class="price-wrapper">
                <label class="description-text">販売価格</label>
                    <input type="number"  name="price" placeholder="￥"  class="price-input">
                @error('price')
                    <div class="error">{{$message}}</div>
                @enderror
            </div><!--price-wrapper-->
<!--出品ボタン-->
    <div class="listing__button">
        <button class="listing__button-submit" type="submit">出品する</button>
    </div><!--listing__button-->
    </form>
</div><!--listing__content-->
@endsection