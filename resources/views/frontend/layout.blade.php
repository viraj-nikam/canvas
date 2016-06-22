<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        @yield('title')

        <meta name="description" content="{{ $meta_description }}">

        <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

        @include('frontend.partials.css')
    </head>
    <body>
        @include('frontend.blog.partials.header')

        @yield('content')

        @yield('unique-js')

        @include('frontend.blog.partials.footer')
    </body>
</html>
