<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <title>Canvas{{ config('app.name') ? ' ― ' . config('app.name') : '' }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Karla|Merriweather:400,700,900">

    @if($scripts['darkMode'] == true)
        <link rel="stylesheet" id="appearance" type="text/css" href="{{ mix('css/app-dark.css', 'vendor/canvas') }}">
    @else
        <link rel="stylesheet" id="appearance" type="text/css" href="{{ mix('css/app.css', 'vendor/canvas') }}">
    @endif

    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/styles/default.min.css">
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/highlight.min.js"></script>

    <link rel="shortcut icon" href="{{ mix('favicon.ico', 'vendor/canvas') }}">
</head>
<body>
<div id="canvas">
    @if(!$assetsUpToDate)
       <div class="alert alert-danger border-0 text-center rounded-0">
           The assets for Canvas are not up-to-date with the installed version.
           To update, run:<br/><code>php artisan canvas:publish</code>
       </div>
    @endif

    <router-view></router-view>
</div>

@javascript('Canvas', $scripts)

<script type="text/javascript" src="{{ mix('js/app.js', 'vendor/canvas') }}"></script>
</body>
</html>
