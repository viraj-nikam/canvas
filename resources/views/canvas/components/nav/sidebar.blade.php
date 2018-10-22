<nav class="sidebar-nav">
    <div class="sidebar-header">
        <button class="nav-toggler nav-toggler-md sidebar-toggler" data-target="#nav-toggleable-md" data-toggle="collapse" type="button"><span class="sr-only">Toggle nav</span></button>
        <a class="sidebar-brand img-responsive" href="{{ route('canvas.index') }}">
            <i class="far fa-newspaper fa-3x" data-fa-transform="shrink-6" data-fa-mask="fas fa-circle"></i>
        </a>
    </div>
    <div class="collapse nav-toggleable-md" id="nav-toggleable-md">
        <form class="sidebar-form">
            <input class="form-control form" placeholder="Search" type="text">
            <button class="btn-link" type="submit">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </form>
        <ul class="nav nav-pills nav-stacked flex-column">
            <li class="nav-header">Resources</li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('canvas.post*') ? 'active' : '' }}" href="{{ route('canvas.post.index') }}">Posts</a>
            </li>
        </ul>
        <hr class="visible-xs mt-3">
    </div>
</nav>