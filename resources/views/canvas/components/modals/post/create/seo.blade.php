<div class="modal fade" id="modal-seo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-weight-bold lead">SEO & Social</p>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="meta_description" class="font-weight-bold">Meta Description</label>
                        <input type="text" class="form-control border-0 px-0"
                               name="meta_description" title="Meta Description" value="{{ old('meta_description') }}"
                               placeholder="Meta Description">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="og_title" class="font-weight-bold">Facebook Card Title</label>
                        <input type="text"
                               class="form-control border-0 px-0"
                               name="og_title" title="Facebook Card Title" value="{{ old('og_title') }}"
                               placeholder="Title in Facebook Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="og_description" class="font-weight-bold">Facebook Card Description</label>
                        <input type="text"
                               class="form-control border-0 px-0"
                               name="og_description" title="Facebook Card Description"
                               value="{{ old('og_description') }}"
                               placeholder="Description in Facebook Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="twitter_title" class="font-weight-bold">Twitter Title</label>
                        <input type="text" class="form-control border-0 px-0"
                               name="twitter_title" title="Twitter Card Title" value="{{ old('twitter_title') }}"
                               placeholder="Title in Twitter Card">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="twitter_description" class="font-weight-bold">Twitter Card Description</label>
                        <input type="text"
                               class="form-control border-0 px-0"
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