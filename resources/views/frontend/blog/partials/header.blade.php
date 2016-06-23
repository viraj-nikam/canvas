<div class="container" id="head-c">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <h1><a href="/">{{ config('blog.title') }}</a></h1>

            @if(isset($user->twitter))
                <a href="http://twitter.com/{{ $user->twitter }}j" target="_blank" id="social"><i class="fa fa-fw fa-twitter"></i> </a>
            @endif
            @if(isset($user->facebook))
                <a href="http://facebook.com/{{ $user->facebook }}" target="_blank" id="social"><i class="fa fa-fw fa-facebook"></i> </a>
            @endif
            <a href="/rss" target="_blank" id="social"><i class="fa fa-fw fa-rss"></i></a>
        </div>
    </div>
</div>