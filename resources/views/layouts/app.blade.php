<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta -->
    @stack('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title')</title>

    <!-- HighlightJS scripts -->
    <script src="{{ url('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.1/build/highlight.min.js') }}"></script>

    <!-- HighlightJS sheets -->
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.1/build/styles/github.min.css') }}">

    <!-- Style sheets -->
    <link rel="stylesheet" type="text/css" href="{{ mix('app.css', 'vendor/canvas') }}">

    <!-- Additional style sheets -->
    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('body')
    </div>

    <!-- Application scripts -->
    <script type="text/javascript" src="{{ mix('app.js', 'vendor/canvas') }}"></script>

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>