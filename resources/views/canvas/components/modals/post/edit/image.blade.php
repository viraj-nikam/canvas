<div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-weight-bold lead">Featured image</p>

                {{-- todo: reason for double quotes here? --}}
                <featured-image-uploader
                        :post="'{{ $data['post']->id }}'"
                        :url="'{{ $data['post']->featured_image }}'"
                        :caption="'{{ $data['post']->featured_image_caption }}'">
                </featured-image-uploader>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted"data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>