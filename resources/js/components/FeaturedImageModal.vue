<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" id="featuredImageModal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.image.header }}</p>

                    <div v-if="form.featured_image" id="currentImage">
                        <img :src="form.featured_image" class="w-100">

                        <div class="input-group py-2">
                            <input type="text" class="form-control border-0 px-0"
                                   name="featured_image_caption"
                                   v-model="form.featured_image_caption"
                                   @blur="update"
                                   :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder">
                        </div>
                    </div>

                    <div v-if="form.featured_image">
                        <a href="#" @click="clear">{{ trans.posts.forms.editor.images.picker.clear.action }}</a>
                        {{ trans.posts.forms.editor.images.picker.clear.description }}
                    </div>

                    <image-picker
                        v-else
                        :image-url="form.featured_image"
                        @changed="update"
                        @clearSelectedImage="clear"
                        @isUploading="isUploading = true">
                    </image-picker>
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
    import { Bus } from '../bus';
    import ImagePicker from "./ImagePicker";

    export default {
        name: 'featured-image-modal',

        props: {
            input: {
                type: Object,
                required: true
            }
        },

        components: {
            ImagePicker
        },

        data() {
            return {
                form: {
                    featured_image: '',
                    featured_image_caption: '',
                },
                isUploading: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.form.featured_image = this.input.featured_image;
            this.form.featured_image_caption = this.input.featured_image_caption;
        },

        methods: {
            update({url, caption}) {
                this.form.featured_image = url || this.form.featured_image;
                this.form.featured_image_caption = caption || this.form.featured_image_caption;
                this.isUploading = false;

                Bus.$emit('updating', this.form);
            },

            clear() {
                this.form.featured_image = '';
                this.form.featured_image_caption = '';
            }
        }
    }
</script>
