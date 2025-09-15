@extends('layouts.default')
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css')}}"/>
@endsection
@section('content')

<!--ログインフォーム-->
<form action="{{ route('login') }}" method="post" class="form">
    @csrf
<div class="login__content">
    <div class="login__form">
        <div class="login__title">
            <h2>ログイン</h2>
        </div><!---login__title-->
<!--メールアドレス-->
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old ('email') }}">
                @error('email')
                    <div class="error">{{$message}}</div>
                @enderror
            </div>
<!--パスワード-->
            <div class="form-group-ttl">
                <label>パスワード</label>
                <input type="password" name="password">
                @error('password')
                    <div class="error">{{$message}}</div>
                @enderror
            </div><!--form-group-ttl-->
        <div class="login__button">
        <button class="login__button-submit" type="submit">ログインする</button>
        </div><!--login-button-->
        <div class="register-link">
            <a href="/register">会員登録はこちら</a>
        </div>
    </form>
    </div><!--login__form-->
</div><!--login__content-->
@endsection