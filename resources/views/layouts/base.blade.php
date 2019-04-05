<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-learning Platform</title>

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <link href="/assets/css/core.min.css" rel="stylesheet">
    <link href="/assets/css/thesaas.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
    <link rel="icon" href="/assets/img/favicon.png">

    <style>
        .main{
            margin: 30px 50px 100px;
            box-shadow: 0 0 35px rgba(0, 0, 0, 0.1);
            border: 1px solid #ebebeb;

        }

    </style>
    @yield('style')
</head>
<body>
<div id="app">
    <nav class="topbar topbar-expand-md">
        <div class="container">

            <div class="topbar-left">
                <button class="topbar-toggler">☰</button>
                <a class="topbar-brand" href="{{url('/')}}"><h3>Question and Answer</h3>
                    {{--<img class="logo-default" src="assets/img/q_a.png" alt="logo">--}}
                    {{--<img class="logo-inverse" src="assets/img/logo-light.png" alt="logo">--}}
                </a>
            </div>


            <div class="topbar-right">
                @auth
                <ul class="topbar-nav nav">
                    <li class="nav-item"><a class="nav-link" href="#">{{auth()->user()->name}}</a></li>
                </ul>
                @endauth

                @guest
                    <div class="d-inline-flex ml-30">
                        <a class="btn btn-sm btn-primary mr-4" href="{{url('/login')}}">Login</a>
                        <a class="btn btn-sm btn-outline btn-primary hidden-sm-down" href="{{url('/register')}}">Register</a>
                    </div>
                    @else
                    <div class="d-inline-flex ml-30">
                        <a class="btn btn-sm btn-danger mr-4" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>

        </div>
    </nav>



    @yield('header')

    <main class="main-content main">
        @yield('content')
    </main>




</div>
<script src="/assets/js/core.min.js"></script>
<script src="/assets/js/thesaas.min.js"></script>
<script src="/assets/js/script.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
