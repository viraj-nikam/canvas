<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ route('canvas.index') }}">
            Canvas
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-muted" href="{{ url('https://github.com/cnvs/canvas/releases') }}" target="_blank">
                        <strong>v4.0.0</strong>
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Posts
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{ Route::is('canvas.post.index') ? 'active' : '' }}" href="{{ route('canvas.post.index') }}">
                            All Posts
                        </a>
                        <a class="dropdown-item {{ Route::is('canvas.post.create') ? 'active' : '' }}" href="{{ route('canvas.post.create') }}">
                            New Post
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>