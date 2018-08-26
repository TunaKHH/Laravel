<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
        crossorigin="anonymous">

    <style>
        body {
            font-family: 微軟正黑體, arial;
        }

        .top-buffer {
            margin-top: 20px;
        }
        /* 以下為switch相關CSS樣板 */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #ec971f;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #ec971f;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        /* switch相關CSS樣板結束 */

    </style>


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Drink') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @guest @else
                        <li class="nav-item">
                            <a class="nav-link" id="pills-order-tab" href="order" role="tab" aria-controls="pills-order" aria-selected="true">訂單管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-store-tab" href="store" role="tab" aria-controls="pills-store" aria-selected="false">店家管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-menu-tab" href="#pills-menu" role="tab" aria-controls="pills-menu" aria-selected="false">菜單管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-authority-tab" href="#pills-authority" role="tab" aria-controls="pills-authority" aria-selected="false">權限管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-track-tab" href="#pills-track" role="tab" aria-controls="pills-track" aria-selected="false">訂購紀錄</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link active" id="pills-order-tab" data-toggle="pill" href="#pills-order" role="tab" aria-controls="pills-order"
                                aria-selected="true">訂單管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-store-tab" data-toggle="pill" href="#pills-store" role="tab" aria-controls="pills-store"
                                aria-selected="false">店家管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-menu-tab" data-toggle="pill" href="#pills-menu" role="tab" aria-controls="pills-menu"
                                aria-selected="false">菜單管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-authority-tab" data-toggle="pill" href="#pills-authority" role="tab" aria-controls="pills-authority"
                                aria-selected="false">權限管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-track-tab" data-toggle="pill" href="#pills-track" role="tab" aria-controls="pills-track"
                                aria-selected="false">訂購紀錄</a>
                        </li> -->
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
