<div class="modal fade" id="modal-seo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="meta_description" class="font-weight-bold">Meta Description</label>
                        <input type="text" class="form-control"
                               name="meta_description" title="Meta Description" value="{{ old('meta_description') }}"
                               placeholder="Meta Description">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="og_title" class="font-weight-bold">Facebook Card Title</label>
                        <input type="text"
                               class="form-control"
                               name="og_title" title="Facebook Card Title" value="{{ old('og_title') }}"
                               placeholder="Title in Facebook Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="og_description" class="font-weight-bold">Facebook Card Description</label>
                        <input type="text"
                               class="form-control"
                               name="og_description" title="Facebook Card Description"
                               value="{{ old('og_description') }}"
                               placeholder="Description in Facebook Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="twitter_title" class="font-weight-bold">Twitter Card Title</label>
                        <input type="text" class="form-control"
                               name="twitter_title" title="Twitter Card Title" value="{{ old('twitter_title') }}"
                               placeholder="Title in Twitter Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="twitter_description" class="font-weight-bold">Twitter Card Description</label>
                        <input type="text"
                               class="form-control"
                               name="twitter_description" title="Twitter Card Description"
                               value="{{ old('twitter_description') }}"
                               placeholder="Description in Twitter Card">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>