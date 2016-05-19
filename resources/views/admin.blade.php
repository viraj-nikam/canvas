<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta')

        @include('shared.fontawesome')

        @yield('title')

        <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">

        @yield('styles')

    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('site.admin.partials.header')

            @yield('content')

            @include('site.admin.partials.footer')

        @endif

        <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>

        @yield('scripts')
    </body>
</html>