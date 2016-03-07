<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="{{ config('blog.author') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @yield('title')
    <link href="/assets/css/admin.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
@if (Auth::guest())
    @yield('login')
@else
    @include('admin.partials.navbar')
    @yield('content')
    @include('admin.partials.footer')
@endif
<script src="/assets/js/admin.js"></script>
@yield('scripts')
</body>
</html>