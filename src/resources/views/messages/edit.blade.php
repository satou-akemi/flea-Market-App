@extends('layouts.default')
@section('css')
<link rel="stylesheet" href="{{asset('css/edit.css')}}">
@endsection

@section('content')
<div class="edit-message">
    <form action="{{ route('message.update',$message->id)}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="message_text" value="{{$message->message_text}}">
        <button type="submit">更新</button>
    </form>
</div>
@endsection