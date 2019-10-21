<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" id="featuredImageModal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ trans.posts.forms.image.header }}
                    </p>

                    <div v-if="storeState.form.featured_image" id="currentImage">
                        <img :src="storeState.form.featured_image" :alt="storeState.form.featured_image_caption" class="w-100"/>

                        <div class="input-group py-2">
                            <input
                                type="text"
                                class="form-control border-0 px-0 bg-transparent"
                                @input="update"
                                name="featured_image_caption"
                                v-model="storeState.form.featured_image_caption"
                                :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder"
                            />
                        </div>
                    </div>

                    <div v-if="storeState.form.featured_image">
                        <a href="#" @click="clear" class="text-decoration-none text-success">
                            {{ trans.posts.forms.editor.images.picker.clear.action }}
                        </a>

                        {{ trans.posts.forms.editor.images.picker.clear.description }}
                    </div>

                    <image-picker
                        v-else
                        :image-url="storeState.form.featured_image"
                        @changed="update"
                        @clearSelectedImage="clear"
                        @isUploading="isUploading = true"
                    />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link font-weight-bold text-muted text-decoration-none" data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ImagePicker from "./ImagePicker";
    import {store} from "../screens/posts/store";

    export default {
        name: "featured-image-modal",

        components: {
            ImagePicker
        },

        data() {
            return {
                storeState: store.state,
                isUploading: false,
                trans: JSON.parse(Canvas.lang)
            };
        },

        methods: {
            clear() {
                this.storeState.form.featured_image = "";
                this.storeState.form.featured_image_caption = "";
            },

            update({url, caption}) {
                if (url) {
                    this.storeState.form.featured_image = url;
                }
                if (caption) {
                    this.storeState.form.featured_image_caption = caption;
                }

                this.$parent.save();
                this.isUploading = false;
            },
        }
    };
</script>
