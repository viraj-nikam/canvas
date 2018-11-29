<div class="modal fade" id="modal-seo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Meta Description</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control"
                               name="meta_description" title="Meta Description" value="{{ old('meta_description') }}"
                               placeholder="Meta Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Title</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               name="og_title" title="Facebook Card Title" value="{{ old('og_title') }}"
                               placeholder="Facebook Card Title">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               name="og_description" title="Facebook Card Description"
                               value="{{ old('og_description') }}"
                               placeholder="Facebook Card Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Image</label>
                    <div class="col-lg-8">
                        Please <a href="#">upload</a> an image.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Title</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control"
                               name="twitter_title" title="Twitter Card Title" value="{{ old('twitter_title') }}"
                               placeholder="Twitter Card Title">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               name="twitter_description" title="Twitter Card Description"
                               value="{{ old('twitter_description') }}"
                               placeholder="Twitter Card Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Image</label>
                    <div class="col-lg-8">
                        Please <a href="#">upload</a> an image.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>