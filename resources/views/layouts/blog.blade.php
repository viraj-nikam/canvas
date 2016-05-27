<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Site Meta Tags -->
        @include('shared.meta-tags')

        @yield('title')

        @include('shared.font-awesome')

        <meta name="description" content="{{ $meta_description }}">

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

        <!-- Blog Specific Stylesheet -->
        <link href="/css/blog.css" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        @include('site.blog.partials.header')

        @yield('content')

        @include('site.blog.partials.footer')

        <script type="text/javascript" src="/js/all.js"></script>

        <!-- Page Specific Scripts -->
        @yield('scripts')
    </body>
</html>
