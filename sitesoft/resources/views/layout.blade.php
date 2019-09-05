<!DOCTYPE html>
<html>
<head>
    <title>Сайтсофт</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/common.js"></script>

    {{--    <link rel="stylesheet" href="/css/app.css">--}}
    {{--    <script type="text/javascript" src="/js/app.js"></script>--}}

</head>
<body>

<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="#">Сайтсофт</a>
        <ul class="nav">
            <li class="active"><a href="/">Главная</a></li>
            @if(!auth()->check())
                <li><a href="{!! route('login') !!}">Авторизация</a></li>
                <li><a href="{!! route('register') !!}">Регистрация</a></li>
            @endif
        </ul>

        @if(auth()->check())
            <ul class="nav pull-right">
                <li><a>{{ auth()->user()->name }}</a></li>
                <li class="js-logout-block">
                    <a class="js-logout-block-handler" style="cursor: pointer;">Выход</a>
                    <form action="{!! route('logout') !!}" method="post" class="hide">
                        {!! csrf_field() !!}
                        <button type="submit">Выход</button>
                    </form>
                </li>
            </ul>
        @endif
    </div>
</div>

<div class="row-fluid">
    <div class="span2"></div>
    <div class="span8">
        @yield('content')
    </div>
</div>


</body>


</html>
