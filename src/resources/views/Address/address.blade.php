@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('content')
<div class="address__content">
        <h1 class="address__content-ttl">住所の変更</h1>
    <!--フォーム入力-->
    <div class="address--form">
        <form action="{{ route('address.update') }}"  method="post">
        @csrf
        @method('PUT')
            <input type="hidden" name="product_id" value="{{ $productId }}">
                @if ($errors->any())
                    <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
                @endif
    <!--postal_code-->
            <label class="form__label" for="postal_code">郵便番号</label>
                <input type="text" class="form__input" name="postal_code" id="postal_code" value="{{ old('postal_code',$user->address->postal_code ?? '')}}">
                @error('postal_code')
                <div class="error">{{$message}}</div>
                @enderror
    <!--address-->
                <label class="form__label" for="address">住所</label>
                <input type="text" class="form__input" name="prefecture" id="prefecture" value="{{ old('prefecture',$user->address->prefecture ?? '')}}">
                @error('prefecture')
                <div class="error">{{$message}}
                </div>
                @enderror
    <!--billing-->
                <label class="form__label" for="building">建物名</label>
                <input type="text" class="form__input" name="building" id="building" value="{{ old('building',$user->address->building ?? '')}}">
                @error('building')
                <div class="error">{{$message}}</div>
                @enderror
            </div><!--profile--form-->
            <div class="update__button">
                <button class="update__button-submit" type="submit">更新する</button>
            </div><!--update__button-->
            </div><!--address__form-->
        </form>
</div><!--address__content-->

@endsection