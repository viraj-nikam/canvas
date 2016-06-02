<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')

        @yield('title')

        @include('site.admin.partials.admin-css')
    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('site.admin.partials.header')

            @yield('content')

            @include('site.admin.partials.footer')

            @yield('scripts')

            @include('shared.page-loader')

            @include('site.admin.partials.admin-js')

        @endif

    </body>
</html>