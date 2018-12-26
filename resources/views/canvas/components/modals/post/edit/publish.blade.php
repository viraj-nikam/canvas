<div class="modal fade" id="modal-publish" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Publish date</label>
                        <input name="published_at"
                               type="datetime-local"
                               class="form-control border-0 px-0"
                               value="{{ $data['post']->published_at->format('Y-m-d\TH:i') }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary"
                   onclick="event.preventDefault();document.getElementById('form-edit').submit();"
                   aria-label="Update post">Update post</a>
                <button class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>