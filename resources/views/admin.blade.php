<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta')

        @yield('title')

        @yield('styles')

    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('site.admin.partials.navbar')

            @yield('content')

            @include('site.admin.partials.footer')

        @endif

        <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>

        @yield('scripts')
    </body>
</html>