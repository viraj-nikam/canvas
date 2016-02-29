<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="{{ config('blog.author') }}">
    <title>Canvas</title>
    <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">
    <link rel="stylesheet" type="text/css" href="/assets/css/home.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    @yield('styles')
    @yield('scripts-upper')
</head>
<body>
@yield('content')
<script src="/assets/js/blog.js"></script>
@yield('scripts-lower')
</body>
</html>