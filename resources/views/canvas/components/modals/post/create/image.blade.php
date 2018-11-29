<div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="custom-file b-0">
                    <input type="file" class="custom-file-input mb-2" id="customFile" name="featured_image">
                    <label class="custom-file-label" for="customFile">Please upload an image</label>

                    <input type="text" class="form-control border-0"
                           name="featured_image_caption" title="Featured Image Caption" value="{{ old('featured_image_caption') }}"
                           placeholder="Add a caption for your image">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>