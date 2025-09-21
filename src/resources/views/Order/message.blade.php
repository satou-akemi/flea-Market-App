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
<!--本文-->
<div class="message-content">
    <div class="deal-header">
        <div class="user-img">
            <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'img/default_avatar.png')}}" alt="avatar.jpg">
        </div><!--user-img-->
            <h1 class="deal-title">「{{$client->name}}」さんとの取引画面</h1>
                @if($status == 'is_buyer')
                    <button class="deal-submit finish-btn" type="submit" data-target="reviewModalBuyer">取引を終了する</button>
                @else
                    <button class="deal-submit dummy-btn"type="submit">dummy</button>
                @endif
<!--購入者-->
            @if($status === 'is_buyer' && !$reviewedByBuyer)
            <div class="model" id="reviewModalBuyer">
                <div class="model-content">
                    <h2>取引が完了しました</h2>
                    <p>今回の取引相手はどうでしたか？</p>
            <!-- 星評価 -->
                    <div class="star-container" id="starBuyer">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>
            <!-- フォーム -->
                    <form action="{{ route('review.store',['order'=>$order->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="rating" id="ratingBuyer">
                    <div class="model-content-btn">
                        <button class="model-submit" type="submit">送信する</button>
                    </div><!--model-content-btn-->
                    </form>
                </div><!--model-content-->
            </div><!--model-->
            @endif
<!--出品者-->
            @if($status === 'is_seller' && $reviewedByBuyer && !$reviewedSeller)
            <div class="model" id="reviewModalSeller">
                <div class="model-content">
                    <h2>取引が完了しました</h2>
                    <p>今回の取引相手はどうでしたか？</p>
            <!-- 星評価 -->
                    <div class="star-container" id="starSeller">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>
            <!-- フォーム -->
                    <form action="{{ route('review.store',['order'=>$order->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="ratingSeller" id="ratingSeller">
                    <div class="model-content-btn">
                        <button class="model-submit" type="submit">送信する</button>
                    </div><!--model-content-btn-->
                    </form>
                </div><!--model-content-->
            </div><!--model-->
            @endif
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
                    @if($message->image_path)
                    <img src="{{ asset('storage/' . $message->image_path) }}" alt="message image">
                @endif
                </div><!--other-message-->
            </div><!--chat-message-->
        @endif
    @endforeach
        <footer class="message-footer">
<!--form-->
            <form action="{{ route('message.store',['id' => $order->id]) }}" method="POST" class="deal-message" enctype="multipart/form-data">
            @csrf
            <div class="error">
                @error('message_text')
                    {{$message}}
                @enderror
            </div>
                <input type="text" name="message_text" value="{{ old('message_text')}} " placeholder="取引メッセージを記入してください">

<!-- 画像追加ボタン -->
                <label for="file-input">画像を追加
                </label>
                <input type="file" name="add-image" id="file-input" class="d-none">

<!-- プレビュー画像 -->
                <img src="" alt="プレビュー画像" id="preview" class="preview" style="display:none">
                <button type="submit">
                    <img src="{{asset('img/send.jpg')}}" alt="" class="send-img">
                </button>
            </form>
        </footer>
    </div>
</div><!--message-content-->
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // モーダルを開くボタン
    document.querySelectorAll('.deal-submit[data-target]').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.target;
            const modal = document.getElementById(targetId);
            if(modal) modal.style.display = 'block';
        });
    });

    // 購入者用星評価
    const starsBuyer = document.querySelectorAll('#starBuyer .star');
    const ratingBuyerInput = document.querySelector('#ratingBuyer');
    if(starsBuyer.length && ratingBuyerInput){
        starsBuyer.forEach((star, index) => {
            star.addEventListener('click', () => {
                ratingBuyerInput.value = star.dataset.value;
                starsBuyer.forEach(s => s.style.color = '#d9d9d9');
                for(let i = 0; i <= index; i++) starsBuyer[i].style.color = 'gold';
            });
        });
    }

    // 出品者用星評価
    const starsSeller = document.querySelectorAll('#starSeller .star');
    const ratingSellerInput = document.querySelector('#ratingSeller');
    if(starsSeller.length && ratingSellerInput){
        starsSeller.forEach((star, index) => {
            star.addEventListener('click', () => {
                ratingSellerInput.value = star.dataset.value;
                starsSeller.forEach(s => s.style.color = '#d9d9d9');
                for(let i = 0; i <= index; i++) starsSeller[i].style.color = 'gold';
            });
        });
    }

    document.querySelectorAll('.model-submit').forEach(button => {
        button.addEventListener('click', () => {
            const modal = submit.closest('.model');
            if(modal) modal.style.display = 'none';
        });
    });

    const fileInput = document.querySelector('#file-input');
const previewImage = document.querySelector('#preview');

if(fileInput && previewImage){
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewImage.style.display = 'none';
        }
    });
}


});

</script>

@endsection
