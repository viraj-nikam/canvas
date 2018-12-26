<div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-weight-bold lead">Featured image</p>

                <div class="form-group row">
                    <div class="col-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="featured_image" name="featured_image" hidden>
                            <label for="featured_image">Please <span style="cursor: pointer"><u>upload</u></span> an image</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="featured_image_caption" class="font-weight-bold">Caption</label>
                        <input type="text" class="form-control border-0 px-0"
                               name="featured_image_caption" title="Featured Image Caption" value="{{ old('featured_image_caption') }}"
                               placeholder="Add a caption for your image">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>