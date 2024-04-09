<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Atte</title>
    <link rel="stylesheet" href=" {{ asset('css/sanitize.css') }} ">
    <link rel="stylesheet" href=" {{ asset('css/common.css') }} ">
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__ttl">Atte</h1>
                @yield('header')
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
        <footer class="footer">
            <small class="footer__small">Atte, inc.</small>
        </footer>
    </div>
</body>
</html>