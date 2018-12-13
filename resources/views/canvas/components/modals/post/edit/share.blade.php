<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-weight-bold lead">Share this Post</p>

                <p>
                    <a href="https://facebook.com/sharer/sharer.php?u={{ route('blog.post.show', $data['post']->slug) }}"
                       class="text-muted" target="_blank"><i class="fab fa-facebook-f fa-fw pr-4"></i>Share on Facebook</a>
                </p>
                <p>
                    <a href="https://twitter.com/intent/tweet/?url={{ route('blog.post.show', $data['post']->slug) }}"
                       class="text-muted" target="_blank"><i class="fab fa-twitter fa-fw pr-4"></i>Share on Twitter</a>
                </p>
                <div class="form-group row col-12">
                    <label for="published_at" class="font-weight-bold">Copy Link</label>
                    <input class="form-control border-0 px-0" type="text" placeholder="Post URL"
                           value="{{ route('blog.post.show', $data['post']->slug) }}"
                           onclick="this.focus();this.select()">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>