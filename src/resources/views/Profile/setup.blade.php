@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/setup.css')}}"/>
@endsection
@section('content')
<div class="profile__content">
<!--プロフィール設定-->
    <div class="profile__content-ttl">
        <h1>プロフィール設定</h1>
    </div><!--profile__content-ttl-->
    <!--フォーム入力-->
    <form action="/update" class="form" method="post" enctype="multipart/form-data">
    @csrf
        <div class="user-information">
    <!--アバター-->
            <div class="user__image">
            <img src="{{ $user->avatar ? asset('img/avatar/' . $user->avatar) : asset('img/default-avatar.png') }}" alt="アバター" width="30" height="30">
        </div><!--user__image-->
        <div class="select__avatar">
            <label for="avatar" class="select-button">画像を選択する
                <input type="file" name="avatar" id="avatar" class="d-none"></label>
                @error('avatar')
                    <div class="error">{{ $message}}
                    </div><!--error-->
                @enderror
        </div><!--select__avatar-->
    </div><!--user-information-->
    <!--name-->
            <div class="profile--form">
                <label class="form__label" for="name">ユーザー名</label>
                <input type="text" class="form__input" name="name"id="name" value="{{ old('name',$user->name)}}">
    <!--postal_code-->
            <label class="form__label" for="postal_code">郵便番号</label>
                <input type="text" class="form__input" name="postal_code" id="postal_code" value="{{ old('postal_code',$user->postal_code)}}"autocomplete="postal-code">
    <!--address-->
                <label class="form__label" for="prefecture">住所</label>
                <input type="text" class="form__input" name="prefecture" id="prefecture" value="{{ old('prefecture',$user->prefecture)}}"autocomplete="address-level1">
    <!--billing-->
                <label class="form__label" for="building">建物名</label>
                <input type="text" class="form__input" name="building" id="building" value="{{ old('building',$user->building)}}"autocomplete="address-line2">
            </div><!--profile--form-->
            <div class="update__button">
                <button class="update__button-submit" type="submit">更新する</button>
            </div><!--update__button-->
        </form>
</div><!--profile__content-->
@endsection
