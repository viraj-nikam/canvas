<template>
    <div v-cloak>
        <img :src="imageUrl" class="w-100">

        <div class="input-group py-2">
            <input type="text"
                   class="form-control border-0 px-0"
                   name="featured_image_caption"
                   v-model="imageCaption"
                   @change="update"
                   :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder">
        </div>

        <input hidden type="hidden" name="featured_image" v-model="imageUrl">

        <image-picker
            @changed="updateImage"
            @uploading="isUploading = true">
        </image-picker>
    </div>
</template>

<script>
    import _ from 'lodash';
    import { Bus } from '../bus';
    import ImagePicker from "./ImagePicker";

    /**
     * Upload a featured image.
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: 'featured-image-uploader',

        props: {
            postId: {
                type: String,
                required: true
            },

            featuredImage: {
                type: String,
                required: false
            },

            featuredImageCaption: {
                type: String,
                required: false
            },
        },

        components: {
            ImagePicker
        },

        data() {
            return {
                imageUrl: '',
                imageCaption: '',
                isReady: false,
                isUploading: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        created() {
            this.imageUrl = this.featuredImage;
            this.imageCaption = this.featuredImageCaption;
            this.isReady = true;
        },

        methods: {
            update: _.debounce(function (e) {
                Bus.$emit('updating');
            }, 700)
            // saveImage() {
            //     this.$emit('changed', {
            //         url: this.imageUrl,
            //         caption: this.imageCaption
            //     });
            //
            //     this.close();
            // },
            //
            // close() {
            //     this.modalShown = false;
            // },
            //
            // updateImage({url, caption}) {
            //     this.imageUrl = url;
            //     this.imageCaption = caption;
            //
            //     this.isUploading = false;
            // },
        }
    }
</script>
