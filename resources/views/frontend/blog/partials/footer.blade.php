<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            @include('frontend.blog.partials.disqus')
        </div>
    </div>
    <center>
        <div class="links">
            @if(null != config('blog.twitter')) <a href="{{ config('blog.twitter') }}" target="_blank"><i class="fa fa-fw fa-twitter"></i></a> @endif
            @if(null != config('blog.github')) <a href="{{ config('blog.github') }}" target="_blank"><i class="fa fa-fw fa-github"></i></a> @endif
            @if(null != config('blog.facebook')) <a href="{{ config('blog.facebook') }}" target="_blank"><i class="fa fa-fw fa-facebook"></i></a> @endif
            @if(null != config('blog.linkedin')) <a href="{{ config('blog.linkedin') }}" target="_blank"><i class="fa fa-fw fa-linkedin"></i></a> @endif
            @if(null != config('blog.instagram')) <a href="{{ config('blog.instagram') }}" target="_blank"><i class="fa fa-fw fa-instagram"></i></a> @endif
            @if(null != config('blog.bitbucket')) <a href="{{ config('blog.bitbucket') }}" target="_blank"><i class="fa fa-fw fa-bitbucket"></i></a> @endif
            @if(null != config('blog.googleplus')) <a href="{{ config('blog.googleplus') }}" target="_blank"><i class="fa fa-fw fa-google-plus"></i></a> @endif
            <a href="/rss" target="_blank"><i class="fa fa-fw fa-rss"></i></a>
        </div>
    </center>
    <br>
    <p align="center">&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. All Rights Reserved</p>
</div>