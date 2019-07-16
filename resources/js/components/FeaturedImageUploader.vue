<template>
    <div v-cloak>
        <div v-if="imageUrl" id="current-image">
            <img :src="imageUrl" class="w-100">

            <div class="input-group py-2">
                <input type="text" class="form-control border-0 px-0"
                       name="featured_image_caption"
                       title="Featured Image Caption"
                       v-model="imageCaption"
                       :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder">
            </div>
        </div>

        <input hidden type="hidden" name="featured_image" v-model="imageUrl">

        <image-picker
                @changed="updateImage"
                @uploading="uploading = true">
        </image-picker>
    </div>
</template>

<script>
    /**
     * Upload a featured image.
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: 'featured-image-uploader',

        props: {
            post: {
                type: String,
                required: true
            },
            url: {
                type: String,
                required: false
            },
            caption: {
                type: String,
                default: ''
            },
        },

        data() {
            return {
                imageUrl: '',
                imageCaption: '',
                uploading: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.imageUrl = this.url;
            this.imageCaption = this.caption;
        },

        methods: {
            saveImage() {
                this.$emit('changed', {
                    url: this.imageUrl,
                    caption: this.imageCaption
                });

                this.close();
            },

            close() {
                this.modalShown = false;
            },

            updateImage({url, caption}) {
                this.imageUrl = url;
                this.imageCaption = caption;

                this.uploading = false;
            },
        }
    }
</script>
