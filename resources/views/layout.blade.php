<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta -->
    @stack('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>Canvas</title>

    <!-- HighlightJS scripts -->
    <script src="{{ url('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.6/build/highlight.min.js') }}"></script>

    <!-- HighlightJS sheets -->
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.6/build/styles/default.min.css') }}">

    <!-- NProgress sheets -->
    <link  rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.css') }}">

    <!-- Style sheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset(mix(sprintf('css/%s', $canvasCssFile), 'vendor/canvas')) }}">

    <!-- Icon -->
    <link rel="shortcut icon" href="{{ mix('favicon.ico', 'vendor/canvas') }}">

    <!-- Additional style sheets -->
    @stack('styles')
</head>
<body>
<div id="canvas">
    <div class="border-bottom">
        <div class="container d-flex justify-content-center px-0">
            <div class="col-md-10 px-0">
                <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                    <!-- Left Side Of Navbar -->
                    <router-link to="/" class="navbar-brand logo mr-4 font-weight-bold py-0 @hasSection('context') d-none d-md-block @endif">
                        <i class="fas fa-align-left"></i>
                    </router-link>
                    <ul class="navbar-nav mr-auto flex-row float-right">
                        <li class="text-muted font-weight-bold">
                            @yield('context')
                            @if(session('notify'))
                                @hasSection('context') — @endif
                                <span class="text-success">{{ session('notify') }}</span>
                            @endif
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    @auth()
                        @yield('actions')

                        <div class="dropdown">
                            <a href="#" id="navbarDropdown" class="nav-link px-0 text-secondary" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ sprintf('%s%s%s', 'https://secure.gravatar.com/avatar/', md5(strtolower(trim(auth()->user()->email))), '?s=200') }}"
                                     class="rounded-circle my-0"
                                     style="width: 31px"
                                     alt="{{ auth()->user()->name }}"
                                >
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <router-link to="/posts" class="dropdown-item">
                                    <span>{{ __('canvas::nav.user.posts') }}</span>
                                </router-link>
                                <router-link to="/tags" class="dropdown-item">
                                    <span>{{ __('canvas::nav.user.tags') }}</span>
                                </router-link>
                                <router-link to="/topics" class="dropdown-item">
                                    <span>{{ __('canvas::nav.user.topics') }}</span>
                                </router-link>
                                <router-link to="/stats" class="dropdown-item">
                                    <span>{{ __('canvas::nav.user.stats') }}</span>
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('canvas::nav.user.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                        </div>
                    @endauth
                </nav>
            </div>
        </div>
    </div>


    <main class="py-4">
        <router-view></router-view>
    </main>
</div>

<!-- Global Canvas Object -->
<script type="text/javascript">
    window.Canvas = @json($canvasScriptVariables);
</script>

<!-- Application scripts -->
<script type="text/javascript" src="{{ mix('js/app.js', 'vendor/canvas') }}"></script>

<!-- Additional scripts -->
@stack('scripts')
</body>
</html>
