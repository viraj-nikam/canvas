<!-- todo: when creating a post, featured_image has an instance of UploadedFile instead of the image url -->
<!-- todo: when updating a post, featured_image is no longer present in the request() -->

<script type="text/ecmascript-6">
    import axios from 'axios';

    export default {
        props: [],

        data() {
            return {
                url: '',
            }
        },

        methods: {
            // Upload the selected image
            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let formData = new FormData();

                formData.append('image', file, file.name);

                this.$emit('uploading');

                axios.post('/canvas/media/uploads', formData).then(response => {
                    this.$emit('changed', {url: response});
                }).catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>

<template>
    <div>
        <input hidden type="file" class="custom-file-input" :id="'imageUpload'+_uid"
               accept="image/*" v-on:change="uploadSelectedImage">
        <div class="mb-0">
            Please <label :for="'imageUpload'+_uid" class="text-primary" style="cursor:pointer;">upload</label> an image
        </div>
    </div>
</template>