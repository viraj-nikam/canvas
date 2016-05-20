<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta')

        @yield('title')

        <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/paper/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/assets/css/custom.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        @if (Auth::guest())

            @yield('login')

        @else

            @include('site.admin.partials.header')

            <div class="container">

                @yield('content')

                @include('site.admin.partials.footer')

            </div>

        @endif

        <script   src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://bootswatch.com/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        @yield('scripts')
    </body>
</html>