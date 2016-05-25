<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Site Meta Tags -->
        @include('shared.meta-tags')

        <title>{{ config('blog.title') }}</title>

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

        <!-- Landing Page Specific Stylesheet -->
        <link href="{{ elixir('css/landing.css') }}" rel="stylesheet">

        <!-- Bootstrap Paper Stylesheet CDN -->
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/paper/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/assets/css/custom.min.css">

        @include('shared.font-awesome')

        @yield('styles')
    </head>
    <body>
        @yield('content')

        <!-- Page Specific Scripts -->
        @yield('scripts')
    </body>
</html>