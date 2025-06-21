<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/sanitize.css')}}"/>

@if(Auth::check())
    <link rel="stylesheet" href="{{ asset('css/login.css')}}"/>
@else
    <link rel="stylesheet" href="{{ asset('css/logout.css')}}"/>
@endif

@yield('css')
@yield('font')
</head>
<body>
<header class="header">
    <nav class="nav_bar">
            <a class="header_logo" href="/"><img src="{{ asset('img/logo.svg')}}" alt="logo"></a>
<!--検索フォーム-->
    <form class="search_form" action="{{ route('products.index') }}" method="GET">
        <input type="text" class="search_form-input" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
    </form>
<!--ナビ-->
        <ul class="nav_list-group">
            @if(Auth::check())
                    <li>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <button type="submit" class="logout-button">ログアウト</button>
                    </form>
                    </li>
                    <li><a  class="mypage__link" href="{{ route('mypage') }}">マイページ</a></li>
                    <li><a class="sell__link" href="/sell">出品</a></li>
            @else
                    <li>
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <button type="submit" class="logout-button">ログイン</button>
                    </form>
                    </li>
                    <li><a href="{{ route('mypage') }}" class="mypage__link">マイページ</a></li>
                    <li><a class="sell__link" href="/sell">出品</a></li>
                @endif
        </ul>
    </nav>
</header>
    <main>
        @yield('content')
    </main>
</body>
</html>