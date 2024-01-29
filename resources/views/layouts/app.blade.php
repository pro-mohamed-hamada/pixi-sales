<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet"> -->
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('layouts.header')
        <main class="py-4">
        <div class="container-fluid">
            <div class="row ">
            @include('layouts.sidebar')
            @yield('content')
            </div>
        </div>
        </main>
        
        <div class="load_content form-group text-center">
            <img class="load_image" src="{{asset('images/load_image.jpg')}}">
            </div>
            {{-- start show photo section --}}
            <div id="show_photo" class="text-center col-xs-12">
            
            </div>
        </div>
        {{-- end update section --}}
        @if(session('message'))
            <div class="alert_message alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('js/js.js')}}"></script>
        <script src="{{asset('js/jquery.nicescroll.min.js')}}"></script>
</body>
</html>
