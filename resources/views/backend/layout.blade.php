<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        @yield('title')

        @include('backend.partials.backend-css')
    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('backend.partials.header')

            @yield('content')

            @include('shared.page-loader')

            @include('backend.partials.footer')

        @endif

        @include('backend.partials.backend-js')

        @yield('unique-js')

    </body>
</html>