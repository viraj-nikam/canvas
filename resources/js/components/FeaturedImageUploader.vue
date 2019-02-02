<script type="text/ecmascript-6">
    export default {
        props: ['post', 'url', 'caption', 'unsplash'],

        data() {
            return {
                imageUrl: '',
                imageCaption: '',
                imagePickerKey: '',
                uploadProgress: 0,
                uploading: false,
            }
        },

        mounted() {
            this.imageUrl = this.url;
            this.imageCaption = this.caption;
        },

        methods: {
            // Save the image
            saveImage() {
                this.$emit('changed', {url: this.imageUrl, caption: this.imageCaption});

                this.close();
            },

            // Close the modal
            close() {
                this.imagePickerKey = _.uniqueId();

                this.modalShown = false;
            },

            // Update the selected image
            updateImage({url, caption}) {
                this.imageUrl = url.data;
                this.imageCaption = caption;

                this.uploading = false;
            },

            // Update the upload progress
            updateProgress({progress}) {
                this.uploadProgress = progress;
            }
        }
    }
</script>

<template>
    <div>
        <div v-if="imageUrl" id="current-image">
            <img :src="imageUrl" class="w-100">

            <div class="input-group py-2">
                <input type="text" class="form-control border-0 px-0"
                       name="featured_image_caption"
                       title="Featured Image Caption"
                       v-model="imageCaption"
                       placeholder="Add a caption for your image">
            </div>
        </div>

        <input hidden type="hidden" name="featured_image" v-model="imageUrl">

        <image-picker
                @changed="updateImage"
                @progressing="updateProgress"
                @uploading="uploading = true"
                :unsplash="this.unsplash">
        </image-picker>
    </div>
</template>
