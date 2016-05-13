<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            @include('site.blog.partials.disqus')
        </div>
    </div>
    <p align="center">&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. All Rights Reserved</p>
</div>