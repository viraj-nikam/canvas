<template>
    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog" id="featuredImageUnsplashModal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.image.header }}</p>

                    <featured-image-uploader
                            :post="'{{ $data['post']->id }}'"
                            :url="'{{ $data['post']->featured_image }}'"
                            :caption="'{{ $data['post']->featured_image_caption }}'">
                    </featured-image-uploader>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-link text-muted"
                            data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FeaturedImageUploader from 'FeaturedImageUploader';

    export default {
        name: 'image-modal',

        components: {
            FeaturedImageUploader
        },

        data() {
            return {
                trans: JSON.parse(Canvas.lang),
            }
        },
    }
</script>
