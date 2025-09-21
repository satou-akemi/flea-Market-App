@extends('layouts.default')
@section('css')
<link rel="stylesheet" href="{{asset('css/message.css')}}">
<link rel="stylesheet" href="{{asset('css/review.css')}}">
@endsection

@section('content')
<div class="container">
<aside>
    <p class="others-deal">その他の取引</p>
    <ul class="other-orders">
        @foreach($orders as $otherOrder)
            @if($otherOrder->id !== $order->id)
                <li class="dealing">
                    <a href="{{ route('others.show',['id' => $otherOrder->id])}}">{{$otherOrder->product->name}}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</aside>
<div class="message-content">
    <div class="deal-header">
        <div class="user-img">
            <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg">
        </div>
            <h1 class="deal-title">「{{$client->name}}」さんとの取引画面</h1>
                @if($status == 'is_buyer')
                    <button class="deal-submit"type="submit" id="openModel" class="finish-btn">取引を終了する</button>
                @else
                    <button class="deal-submit dummy-btn"type="submit">dummy</button>
                @endif
            <div class="model" id="reviewModel">
                <div class="model-content">
                    <h2>取引が完了しました</h2>
                    <p>今回の取引相手はどうでしたか？</p>
            <!-- 星評価 -->
                    <div id="star">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>
            <!-- フォーム -->
                    <form action="{{ route('review.store',['order'=>$order->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="rating" id="rating">
                    <div class="model-content-btn">
                        <button class="model-submit" type="submit">送信する</button>
                    </div>
                    </form>
                </div>
            </div>
    </div><!--deal-header-->
        <div class="product-information">
            <div class="product-img">
                <img src="{{asset($order->product->image_path)}}" alt="商品画像">
            </div><!--product-img-->
        <div class="price-card">
            <h2 class="product-name">{{$order->product->name}}</h2>
            <p class="product-price">￥{{number_format($order->product->price)}}(税込み)</p>
        </div><!--price-card-->
    </div><!--product-information-->
    @foreach($messages as $message)
        @if($message->user->id === auth()->id())
            <div class="chat-message">
                <div class="my-message">
                <div class="user-info">
                @if($status === 'is_buyer')
                    <div class="buyer-user-img">
                        <img src="{{asset($user->avatar ? 'storage/' .$user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg">
                    </div><!--img-->
                @else
                    <div class="seller-user-img">
                        <img src="{{ asset($user->avatar ? 'storage/' .$user->avatar : 'img/default_avatar.png') }}" alt="avatar.jpg">
                    </div>
                @endif
                    <p class="user-name">{{$message->user->name}}</p>
                </div><!--user-info-->
                    <p class="message-text">{{$message->message_text}}</p>
<!--編集削除-->
                <div class="message-action">
                    <a href="{{ route('message.edit',$message->id)}}" class="edit-button">編集</a>
                    <form action="{{ route('message.destroy',$message->id)}}" method="POST" class="destroy-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">削除</button>
                    </form>
                </div><!--my-message-->
            </div><!--action-->
        </div><!--chat-message-->
        @else
            <div class="chat-message">
                <div class="other-message">
                <div class="user-info">
                @if($status === 'is_buyer')
                    <div class="buyer-user-img">
                        <img src="{{asset($client->avatar ? 'storage/' .$client->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg">
                    </div>
                @endif
                    <p class="user-name">{{$message->user->name}}</p>
                </div><!--user-info-->
                    <p class="message-text">{{$message->message_text}}</p>
                </div><!--other-message-->
            </div><!--chat-message-->
        @endif
    @endforeach
    <img src="" alt="プレビュー画像" id="preview" class="preview">
        <footer class="message-footer">
            <form action="{{ route('message.store',['id' => $order->id]) }}" method="POST" class="deal-message" enctype="multipart/form-data">
            @csrf
            <div class="error">
                @error('message_text')
                    {{$message}}
                @enderror
            </div>
                <input type="text" name="message_text" placeholder="取引メッセージを記入してください">
                <label for="file-input">画像を追加
                </label>
                <input type="file" name="add-image" id="file-input" class="d-none">
                <button type="submit">
                <img src="{{asset('img/send.jpg')}}" alt="" class="send-img">
                </button>
            </form>
        </footer>
    </div>
</div><!--message-content-->
<script>
    const fileInput = document.getElementById('file-input');
    const previewImage = document.getElementById('preview');

    fileInput.addEventListener('change', function() {
    const file = fileInput.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

const modal = document.getElementById('reviewModel');
const openModal = document.getElementById('openModel');
const stars = document.querySelectorAll('.star');
const ratingInput = document.getElementById('rating');

openModal.addEventListener('click', () => {
    modal.style.display = 'block';
    });

stars.forEach(star => {
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            stars.forEach(s => s.style.color = 'gray');
            for (let i = 0; i < star.dataset.value; i++) {
                stars[i].style.color = 'gold';
            }
        });
    });
</script>
@endsection