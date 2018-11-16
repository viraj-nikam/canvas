<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container col-10">
        <a class="navbar-brand p-0 logo" href="{{ route('canvas.index') }}">
            <img src="{{ asset('vendor/canvas/images/logo.png') }}" class="rounded" alt="Canvas Logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item my-auto">
                    <a href="{{ route('canvas.post.create') }}" class="btn btn-sm btn-outline-primary mr-2">
                        New Post
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('canvas.post.index') }}">
                            Posts
                        </a>
                        <a class="dropdown-item" href="{{ route('canvas.tag.index') }}">
                            Tags
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>