<div class="container">
    @if(Config::get('blog.disqus_name'))
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @include('frontend.blog.partials.disqus')
            </div>
        </div>
        <br>
    @endif
    <div style="text-align: center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <hr>
                <p class="small">&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. Code
                    released under the
                    <a href="https://github.com/austintoddj/Canvas/blob/master/LICENSE" target="_blank">MIT License</a>
                </p>
            </div>
        </div>
    </div>
</div>

@if (Config::get('analytics.google'))
    @include('frontend.blog.partials.analytics')
@endif