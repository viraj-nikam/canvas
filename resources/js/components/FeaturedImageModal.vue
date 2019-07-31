<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" id="featuredImageUnsplashModal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.image.header }}</p>

                    <featured-image-uploader
                        :post-id="id"
                        :featured-image="imageUrl"
                        :featured-image-caption="imageCaption">
                    </featured-image-uploader>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FeaturedImageUploader from './FeaturedImageUploader';

    export default {
        name: 'featured-image-modal',

        props: {
            input: {
                type: Object,
                required: true
            }
        },

        components: {
            FeaturedImageUploader
        },

        data() {
            return {
                id: '',
                imageUrl: '',
                imageCaption: '',
                trans: JSON.parse(Canvas.lang),
            }
        },

        created() {
            this.id = this.input.id;
            this.imageUrl = this.input.featured_image;
            this.imageCaption = this.input.featured_image_caption;
        },
    }
</script>
