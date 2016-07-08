<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        @yield('title')

        @include('backend.partials.backend-css')
    </head>

    @if (Auth::guest())
        <body>

        @yield('login')
    @else
        <body class="toggled sw-toggled">

        @include('backend.partials.header')

        @yield('content')

        @include('shared.page-loader')
    @endif

    @include('backend.partials.footer')

    @include('backend.partials.backend-js')

    @include('backend.partials.search-js')

    @yield('unique-js')

    </body>
</html>