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

            @include('backend.partials.footer')

            @yield('scripts')

            @include('shared.page-loader')

            @include('backend.partials.backend-js')

            @yield('unique-js')

        @endif

    </body>
</html>