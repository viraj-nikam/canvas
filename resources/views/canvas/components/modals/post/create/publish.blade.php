<div class="modal fade" id="modal-publish" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Publish Date</label>
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
                   aria-label="Publish this post">Publish</a>
                <button class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>