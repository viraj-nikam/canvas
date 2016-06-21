<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            @include('frontend.blog.partials.disqus')
        </div>
    </div>
</div>
<br />
<footer id="footer">
    &copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. Code released under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a>

    <ul class="f-menu">
        <li><a href="/admin/profile">Profile</a></li>
        <li><a href="/admin/post">Posts</a></li>
        <li><a href="/admin/tag">Tags</a></li>
        <li><a href="/admin/upload">Uploads</a></li>
        <li><a href="https://austintoddj.github.io/Canvas">Support</a></li>
        <li><a href="mailto:austin.todd.j@gmail.com">Contact</a></li>
    </ul>
</footer>