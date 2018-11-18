<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <label class="col-lg-4 col-form-label text-lg-left">Publish at</label>
                    <div class="col-lg-8">
                        <input name="published_at"
                               type="datetime-local"
                               class="form-control{{ $errors->has('published_at') ? ' is-invalid' : '' }}"
                               value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary"
                   onclick="event.preventDefault();document.getElementById('form-create').submit();"
                   aria-label="Publish this post">Schedule to publish</a>
                <button class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>