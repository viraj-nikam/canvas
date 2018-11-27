<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand logo mr-3 font-weight-bold" href="{{ route('canvas.index') }}">
            <span>C</span>anvas
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="text-muted font-weight-bold">
                    @yield('status')
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @yield('actions')

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('canvas.post.index') }}">
                            Posts
                        </a>
                        <a class="dropdown-item" href="{{ route('canvas.tag.index') }}">
                            Tags
                        </a>
                        <a class="dropdown-item" href="{{ route('canvas.index') }}">
                            Stats
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>