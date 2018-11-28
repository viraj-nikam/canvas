<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Deleted posts are gone forever. Are you sure?
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger"
                   onclick="event.preventDefault();document.getElementById('form-delete').submit();"
                   aria-label="Delete Post">Delete</a>
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>

                <form id="form-delete" action="{{ route('canvas.post.destroy', $data['post']->id) }}" method="POST" style="display: none">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>