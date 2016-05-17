<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta')

        <title>{{ config('blog.title') }}</title>

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">
        <link href="{{ elixir('css/landing.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        @include('shared.fontawesome')

        @yield('styles')

        @yield('scripts-upper')
    </head>
    <body>
        @yield('content')

        <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>

        @yield('scripts-lower')
    </body>
</html>