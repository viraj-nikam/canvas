<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        <title>{{ config('blog.title') }}</title>

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

        <link href="/css/landing.css" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        @yield('content')

        @yield('scripts')
    </body>
</html>