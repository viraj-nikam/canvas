<div class="modal fade" id="modal-delete-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deletePostLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePostLabel">Delete Post?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this post? This cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger"
                   onclick="event.preventDefault();document.getElementById('post-delete-{{ $post->id }}').submit();"
                   aria-label="Delete Post">Delete</a>

                <form id="post-delete-{{ $post->id }}" action="{{ route('canvas.posts.destroy', $post->id) }}" method="POST" style="display: none">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>