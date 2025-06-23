@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}"/>
@endsection

@section('content')

@if (session('status') === 'verification-link-sent')
    <div class="message">
        認証メールを再送しました。
    </div>
@endif

<div class="messages">
    <p>登録していただいたメールアドレスに認証メールを送付しました</p>
    <p>メール認証を完了させてください</p>
</div>

<div class="message__button">
    <p>認証はこちらから</p>
</div>

<div class="resend">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class=" resend__button">
            認証メールを再送する
        </button>
    </form>
</div>

@endsection