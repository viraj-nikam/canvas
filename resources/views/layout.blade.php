<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Additional Meta Information -->
    @stack('meta')

    <!-- Application Title -->
    <title>Canvas</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Karla|Merriweather" rel="stylesheet">

    <!-- HighlightJS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset(mix(sprintf('css/%s', $stylesheet), 'vendor/canvas')) }}">

    <!-- Application Icon -->
    <link rel="shortcut icon" href="{{ mix('favicon.ico', 'vendor/canvas') }}">
</head>
<body>
<div id="canvas">
    <router-view></router-view>
</div>

<!-- Canvas Global Object -->
<script type="text/javascript">
    window.Canvas = @json($scripts);
</script>

<!-- Application Scripts -->
<script type="text/javascript" src="{{ mix('js/app.js', 'vendor/canvas') }}"></script>
</body>
</html>
