<form class="keyboard-save" role="form" method="POST" id="settings" action="{{ url('admin/settings') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Blog Title</label>
            <input type="text" class="form-control" name="blog_title" id="blog_title" value="" placeholder="Blog Title">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Blog Subtitle</label>
            <input type="text" class="form-control" name="blog_subtitle" id="blog_subtitle" value="" placeholder="Blog Subtitle">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Blog Description</label>
            <input type="text" class="form-control" name="blog_description" id="blog_description" value="" placeholder="Blog Description">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Blog SEO</label>
            <input type="text" class="form-control" name="blog_seo" id="blog_seo" value="" placeholder="Blog SEO">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Blog Author</label>
            <input type="text" class="form-control" name="blog_author" id="blog_author" value="" placeholder="Blog Author">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Disqus</label>
            <input type="text" class="form-control" name="disqus_name" id="disqus_name" value="" placeholder="Disqus Shortname">
        </div>
    </div>

    <br>

    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Google Analytics</label>
            <input type="text" class="form-control" name="ga_id" id="ga_id" value="" placeholder="Disqus Shortname">
        </div>
    </div>

    <br>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
    </div>
</form>