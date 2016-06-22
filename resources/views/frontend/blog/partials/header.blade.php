<div class="page-header">
    <h1><a href="/">{{ config('blog.title') }}</a></h1>
    <br>
    <div class="links">
        @if(isset($user->twitter))
            <a href="http://twitter.com/{{ $user->twitter }}j" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
        @endif
        @if(isset($user->facebook))
            <a href="http://facebook.com/{{ $user->facebook }}" target="_blank"><i class="fa fa-fw fa-facebook"></i></a>
        @endif
        <a href="/rss" target="_blank"><i class="fa fa-fw fa-rss"></i></a>
    </div>
</div>