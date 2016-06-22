<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            @include('frontend.blog.partials.disqus')
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <center>
                <p>&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. Code released under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a></p>
            </center>
        </div>
    </div>
</div>