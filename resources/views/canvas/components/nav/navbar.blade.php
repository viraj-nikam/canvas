<nav class="navbar navbar-light border-bottom justify-content-between flex-nowrap flex-row">
    <!-- Left Side Of Navbar -->
    <a class="navbar-brand logo mr-4 font-weight-bold py-0 @hasSection('status') d-none d-md-block @endif"
       href="{{ route('canvas.index') }}">
        <span>C</span>anvas
    </a>

    <ul class="navbar-nav mr-auto flex-row float-right">
        <li class="text-muted font-weight-bold">
            @yield('status') @if (session('notify')) — <span class="text-success">{{ session('notify') }}</span>@endif
        </li>
    </ul>

    <!-- Right Side Of Navbar -->
    @yield('actions')

    <div class="dropdown">
        <a id="navbarDropdown" class="nav-link px-0 text-secondary" href="#" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false" v-pre>
            {{ auth()->user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('canvas.post.index') }}">
                Posts
            </a>
            <a class="dropdown-item" href="{{ route('canvas.tag.index') }}">
                Tags
            </a>
        </div>
    </div>
</nav>