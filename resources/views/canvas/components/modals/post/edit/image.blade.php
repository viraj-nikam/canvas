<div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ $data['post']->featured_image }}" alt="" class="w-100 mb-2">

                <input type="text" class="form-control border-0 mb-2"
                       name="featured_image_caption" title="Featured Image Caption" value="{{ $data['post']->featured_image_caption }}"
                       placeholder="Add a caption for your image">

                <div class="custom-file">
                    <input type="file" class="custom-file-input mb-2" id="customFile" name="featured_image">
                    <label class="custom-file-label" for="customFile">Upload a new image</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted"data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>