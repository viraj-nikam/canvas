<template>
    <div v-cloak>
        <div class="modal fade" id="imageUpload" tabindex="-1" role="dialog" data-backdrop="static">
            <div class="modal-dialog" id="unsplashModal" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="font-weight-bold lead">
                            {{ trans.posts.forms.editor.images.picker.uploader.label }}
                        </p>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div v-if="imageUrl" id="current-image">
                                    <img :src="imageUrl" class="w-100">

                                    <div class="input-group py-2">
                                        <input type="text"
                                               class="form-control border-0 px-0"
                                               v-model="caption"
                                               :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder"
                                               ref="caption">
                                    </div>

                                    <div class="input-group py-2">
                                        <select class="custom-select border-0 px-0" v-model="layout">
                                            <option value="default">
                                                {{ trans.posts.forms.editor.images.picker.uploader.layout.default }}
                                            </option>
                                            <option value="wide">
                                                {{ trans.posts.forms.editor.images.picker.uploader.layout.wide }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <image-picker
                                        v-if="!imageUrl"
                                        @changed="updateImage">
                                </image-picker>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link text-muted"
                                data-dismiss="modal"
                                @click="setImage">
                            {{ trans.buttons.general.done }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery';
    import ImagePicker from '../ImagePicker';

    /**
     * This component displays...
     *
     * This component will contain...
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: 'image-uploader',

        components: {
            ImagePicker
        },

        data() {
            return {
                caption: '',
                existingBlot: null,
                imageUrl: null,
                layout: 'default',
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.$parent.$on('openingImageUploader', data => {
                if (data) {
                    this.showImageModal();

                    this.caption = data.caption;
                    this.imageUrl = data.url;
                    this.layout = data.layout || 'default';
                    this.existingBlot = data.existingBlot;
                }
            });
        },

        methods: {
            showImageModal() {
                $('#imageUpload').modal('show');
            },

            clear() {
                this.existingBlot = null;
                this.imageUrl = null;
                this.layout = 'default';
                this.caption = '';
            },

            updateImage({url, caption}) {
                this.imageUrl = url;
                this.caption = caption ? caption : '';
            },

            setImage() {
                if (!this.imageUrl) {
                    return;
                }

                this.$emit('updated', {
                    url: this.imageUrl,
                    caption: this.caption,
                    existingBlot: this.existingBlot,
                    layout: this.layout,
                });

                this.clear();
            }
        }
    }
</script>
