<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>laravel8 VueJS </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarScroll" aria-controls="navbarScroll"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav mr-auto" style="max-height: 100px;">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">перезагрузить</a>
                    </li>

                </ul>
                <span class="navbar-text">
                    <a href="mailto:echo.zahar@gmail.com">Echo Zahar</a>
                </span>
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'products.index'}">продукты</router-link>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#">регистрация</a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'order.checkout'}" tabindex="-1" aria-disabled="true">
                            корзина <span v-text="'(' + $store.state.cart.length + ' items)'"></span>
                        </router-link>
                    </li>
                </ul>

            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
