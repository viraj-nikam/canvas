<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Site Meta Tags -->
        @include('shared.meta-tags')

        @yield('title')

        <!-- Admin Specific Stylesheets -->
        <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">

        <!-- Bootstrap Paper Stylesheet CDN -->
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/paper/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://bootswatch.com/assets/css/custom.min.css">

        <!-- Google Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Admin Specific Styles -->
        @yield('styles')
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

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

        <!-- Bootstrap JS CDN -->
        <script type="text/javascript" src="http://bootswatch.com/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="{{ asset('js/all.js') }}"></script>

        <!-- Admin Specific Scripts -->
        @yield('scripts')
    </body>
</html>