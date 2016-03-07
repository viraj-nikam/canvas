<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta property="og:type" content="blog">

    @yield('og-description')

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    @yield('title')

    <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">
    <link href="/assets/css/blog.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    @yield('styles')

</head>
<body>

@include('blog.partials.page-nav')

@yield('content')

@include('blog.partials.page-footer')

<script src="/assets/js/blog.js"></script>

@yield('scripts')

</body>
</html>