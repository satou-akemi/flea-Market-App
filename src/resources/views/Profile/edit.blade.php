@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/setup.css')}}">
@endsection

@section('content')
<div class="profile__content">
<!--プロフィール設定-->
    <div class="profile__content-ttl">
        <h1>プロフィール設定</h1>
    </div><!--profile__content-ttl-->

    <!--フォーム入力-->
    <form action="{{ route('profile.update')}}" class="form" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="user-information">
    <!--アバター-->
            <div class="user__image">
                <img class="avatar-image" src="{{ asset($user->avatar ?'storage/' .$user->avatar : 'img/default_avatar.png') }}" alt="avatar.jpg" >
        </div><!--user__image-->

        <div class="select__avatar">
            <label for="avatar" class="select-button">画像を選択する</label>
                <input type="file" name="avatar" id="avatar" class="d-none">
                @error('avatar')
                    <div class="error">{{ $message}}
                    </div><!--error-->
                @enderror
        </div><!--select__avatar-->
    </div><!--user-information-->
    <!--name-->
            <div class="profile--form">
                <label class="form__label" for="name">ユーザー名
                <input type="text" class="form__input" name="name"id="name" value="{{ old('name',$user->name)}}"></label>
    <!--postal_code-->
            <label class="form__label" for="postal_code">郵便番号
                <input type="text" class="form__input" name="postal_code" id="postal_code" value="{{ old('postal_code',$address->postal_code)}}"></label>
    <!--address-->
                <label class="form__label" for="address">住所
                <input type="text" class="form__input" name="prefecture" id="prefecture" value="{{ old('prefecture',$address->prefecture)}}"></label>
    <!--billing-->
                <label class="form__label" for="building">建物名
                <input type="text" class="form__input" name="building" id="building" value="{{ old('building',$address->building)}}"></label>
            <div class="update__button">
                <button class="update__button-submit" type="submit">更新する</button>
            </div><!--update__button-->
            </div><!--profile--form-->
        </form>
</div><!--profile__content-->
@endsection