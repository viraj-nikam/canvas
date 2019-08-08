<template>
    <div v-if="isReady">
        <div v-if="url" id="currentImage">
            <img :src="url" class="w-100">

            <div class="input-group py-2">
                <input type="text" class="form-control border-0 px-0"
                       name="featured_image_caption"
                       v-model="caption"
                       @change="update"
                       :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder">
            </div>
        </div>

        <input hidden type="hidden" name="featured_image" v-model="url" @change="update">

        <image-picker
            @changed="update"
            @isUploading="isUploading = true">
        </image-picker>
    </div>
</template>

<script>
    import { Bus } from '../bus';
    import ImagePicker from "./ImagePicker";

    export default {
        components: {
            ImagePicker
        },

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
                default: ''
            },
        },

        data() {
            return {
                url: '',
                caption: '',
                isReady: false,
                isUploading: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.url = this.featuredImage;
            this.caption = this.featuredImageCaption;
            this.isReady = true;
        },

        methods: {
            update({url, caption}) {
                this.url = url;
                this.caption = caption;
                this.isUploading = false;

                Bus.$emit('updating', {
                    featured_image: this.url,
                    featured_image_caption: this.caption,
                })
            },
        }
    }
</script>
