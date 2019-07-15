<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Additional Meta Information -->
    @stack('meta')

    <!-- Application Title -->
    <title>Canvas</title>

    <!-- HighlightJS CDN -->
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.6/build/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.6/build/styles/default.min.css">

    <!-- NProgress CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.css">

    <!-- Application Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset(mix(sprintf('css/%s', $canvasCssFile), 'vendor/canvas')) }}">

    <!-- Application Icon -->
    <link rel="shortcut icon" href="{{ mix('favicon.ico', 'vendor/canvas') }}">
</head>
<body>
<div id="canvas">
    <router-view></router-view>
</div>

<!-- Canvas Global Object -->
<script type="text/javascript">
    window.Canvas = @json($canvasScriptVariables);
</script>

<!-- Application Scripts -->
<script type="text/javascript" src="{{ mix('js/app.js', 'vendor/canvas') }}"></script>
</body>
</html>
