<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div id="imageModal" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ trans.posts.forms.editor.images.picker.uploader.label }}
                    </p>

                    <div class="form-group row">
                        <div class="col-12">
                            <div v-if="imageUrl" id="currentImage">
                                <img :src="imageUrl" :alt="caption" class="w-100"/>

                                <div class="input-group py-2">
                                    <label>
                                        <input
                                            ref="caption"
                                            v-model="caption"
                                            type="text"
                                            class="form-control border-0 px-0"
                                            :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder"
                                        />
                                    </label>
                                </div>

                                <div class="input-group py-2">
                                    <label>
                                        <select v-model="layout" class="custom-select border-0 px-0">
                                            <option value="default">
                                                {{ trans.posts.forms.editor.images.picker.uploader.layout.default }}
                                            </option>
                                            <option value="wide">
                                                {{ trans.posts.forms.editor.images.picker.uploader.layout.wide }}
                                            </option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <ImagePicker
                                :image-url="imageUrl"
                                @changed="updateImage"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link text-muted font-weight-bold text-decoration-none" data-dismiss="modal" @click="setImage">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import ImagePicker from "../ImagePicker";

    /**
     * This component displays...
     *
     * This component will contain...
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: "ImageModal",

        components: {
            ImagePicker
        },

        data() {
            return {
                caption: "",
                existingBlot: null,
                imageUrl: null,
                layout: "default",
                trans: JSON.parse(Canvas.lang)
            };
        },

        mounted() {
            this.$parent.$on("openingImageUploader", data => {
                if (data) {
                    this.showImageModal();

                    this.caption = data.caption;
                    this.imageUrl = data.url;
                    this.layout = data.layout || "default";
                    this.existingBlot = data.existingBlot;
                }
            });
        },

        methods: {
            setImage() {
                if (!this.imageUrl) {
                    return;
                }

                this.$emit("addingImage", {
                    url: this.imageUrl,
                    caption: this.caption,
                    existingBlot: this.existingBlot,
                    layout: this.layout
                });

                this.clearImage();
            },

            updateImage({url, caption}) {
                this.imageUrl = url;
                this.caption = caption ? caption : "";
            },

            clearImage() {
                this.existingBlot = null;
                this.imageUrl = null;
                this.layout = "default";
                this.caption = "";
            },

            showImageModal() {
                $("#imageUpload").modal("show");
            }
        }
    };
</script>
