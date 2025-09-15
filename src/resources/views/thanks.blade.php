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
    このページを閲覧するには、Eメールによる認証が必要です。<br/>
    もし認証用のメールを受け取っていない場合、
</div>

<div class="message__button">
    <a href="http://localhost:8025" target="_blank">認証はこちらから</a>
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