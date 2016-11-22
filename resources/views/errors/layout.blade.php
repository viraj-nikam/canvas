<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')
        @yield('title')
        @include('backend.partials.backend-css')
    </head>
    <body>
        @yield('content')
        @yield('unique-js')
    </body>
</html>
