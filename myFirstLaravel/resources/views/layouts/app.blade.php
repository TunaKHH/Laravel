<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php //session_start();?>
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
    <script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script> -->

    <script src="{{ asset('nicelabel/js/jquery.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link href="{{ asset('nicelabel/css/jquery-nicelabel.css') }}"rel="stylesheet">
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

        /*以下參考 https://bootsnipp.com/snippets/gv6Pe*/
        /*
            "bootstrap4 table #table #checkbox #pagination #bootstrap4 #responsive-table #material-checkbox"
        */

        .table {
            border: none;
        }

        .table-definition thead th:first-child {
            pointer-events: none;
            background: white;
            border: none;
        }

        .table td {
            vertical-align: middle;
        }

        .page-item > * {
            border: none;
        }

        .custom-checkbox {
        min-height: 1rem;
        padding-left: 0;
        margin-right: 0;
        cursor: pointer; 
        }
        .custom-checkbox .custom-control-indicator {
            content: "";
            display: inline-block;
            position: relative;
            width: 30px;
            height: 10px;
            background-color: #818181;
            border-radius: 15px;
            margin-right: 10px;
            -webkit-transition: background .3s ease;
            transition: background .3s ease;
            vertical-align: middle;
            margin: 0 16px;
            box-shadow: none; 
        }
        .custom-checkbox .custom-control-indicator:after {
            content: "";
            position: absolute;
            display: inline-block;
            width: 18px;
            height: 18px;
            background-color: #f1f1f1;
            border-radius: 21px;
            box-shadow: 0 1px 3px 1px rgba(0, 0, 0, 0.4);
            left: -2px;
            top: -4px;
            -webkit-transition: left .3s ease, background .3s ease, box-shadow .1s ease;
            transition: left .3s ease, background .3s ease, box-shadow .1s ease; 
        }
        .custom-checkbox .custom-control-input:checked ~ .custom-control-indicator {
            background-color: #84c7c1;
            background-image: none;
            box-shadow: none !important; 
        }
        .custom-checkbox .custom-control-input:checked ~ .custom-control-indicator:after {
            background-color: #84c7c1;
            left: 15px; 
            }
        .custom-checkbox .custom-control-input:focus ~ .custom-control-indicator {
            box-shadow: none !important; 
        }
        /*以上參考 https://bootsnipp.com/snippets/gv6Pe*/

        /*以下 https://bootsnipp.com/snippets/featured/multi-select-tiled-layout */
        .searchable-container{margin:20px 0 0 0}
        .searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
        .searchable-container label.btn-default{width:90%;border:1px solid #efefef;margin:5px; box-shadow:5px 8px 8px 0 #ccc;}
        .searchable-container label .bizcontent{width:100%;}
        .searchable-container .btn-group{width:90%}
        .searchable-container .btn span.glyphicon{
            opacity: 0;
        }
        .searchable-container .btn.active span.glyphicon {
            opacity: 1;
        }
        /*以上 https://bootsnipp.com/snippets/featured/multi-select-tiled-layout */

    </style>


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Drink') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @guest @else
                        <li class="nav-item">
                            <a class="nav-link" id="pills-order-tab" href="order" role="tab" aria-controls="pills-order"
                                aria-selected="true">訂單管理</a>
                        </li>
                        <?php if($_SESSION['userPermission'] == '0'){ ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-store-tab" href="store" role="tab" aria-controls="pills-store"
                                    aria-selected="false">店家管理</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-permission-tab" href="permission" role="tab" aria-controls="pills-permission" aria-selected="false">權限管理</a>
                            </li>
                        <?php }?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-history-tab" href="history" role="tab" aria-controls="pills-history"
                                aria-selected="false">訂購紀錄</a>
                        </li>
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
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
