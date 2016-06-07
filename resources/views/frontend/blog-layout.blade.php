<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        @yield('title')

        <meta name="description" content="{{ $meta_description }}">

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

        <link href="/css/blog.css" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        @include('site.blog.partials.header')

        @yield('content')

        @include('site.blog.partials.footer')

        <script type="text/javascript" src="/js/all.js"></script>

        @yield('scripts')
    </body>
</html>
