<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta')

        @yield('title')

        <link href="{{ elixir('css/auth.css') }}" rel="stylesheet">

        @yield('styles')

    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('admin.partials.navbar')

            @yield('content')

            @include('admin.partials.footer')

        @endif

        <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>

        @yield('scripts')
    </body>
</html>