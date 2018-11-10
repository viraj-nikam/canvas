<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Publishing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Published At</label>
                    <div class="col-lg-8">
                        <input name="published_at"
                               class="form-control{{ $errors->has('published_at') ? ' is-invalid' : '' }}"
                               value="{{ $data['post']->published_at }}">
                        @if ($errors->has('published_at'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('published_at') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-primary"
                   onclick="event.preventDefault();document.getElementById('form-edit').submit();"
                   aria-label="Update this post">Update</a>
            </div>
        </div>
    </div>
</div>