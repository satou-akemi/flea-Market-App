<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/default.css')}}"/>
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/"><img src="{{ asset('img/logo.svg')}}" alt="logo"></a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>