<template>
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" ref="modal" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <div v-if="unsplashKey" class="input-group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" class="icon-search">
                            <circle cx="10" cy="10" r="7" class="fill-bg"/>
                            <path class="primary" d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
                        </svg>
                        <input
                            v-model="searchKeyword"
                            type="text"
                            autofocus
                            class="form-control border-0 bg-transparent"
                            :placeholder="trans.posts.forms.editor.images.picker.placeholder"
                        />
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="resetComponent">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" class="icon-close-circle">
                            <circle cx="12" cy="12" r="10" class="primary"/>
                            <path class="fill-bg" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <file-pond
                        name="upload"
                        ref="pond"
                        max-files="1"
                        :label-idle="getPlaceholderLabel"
                        accepted-file-types="image/jpeg, image/png"
                        :server="getServerOptions"
                        :allow-multiple="false"
                        :files="myFiles"
                        @init="handleFilePondInit"/>

                    <div v-if="unsplashKey && searchKeyword">
                        <div class="card-columns mt-3">
                            <div v-for="(image, $index) in unsplashImages" :key="$index" class="card border-0">
                                <img
                                    :src="image.urls.small"
                                    :alt="image.alt_description"
                                    class="card-img"
                                    style="cursor: pointer"
                                    @click="selectUnsplashImage(image)"
                                />
                            </div>

                            <infinite-loading :identifier="infiniteId" @infinite="fetchUnsplashImages" spinner="spiral">
                            </infinite-loading>
                        </div>
                    </div>

                    <div v-if="selectedImageUrl" class="form-group row">
                        <div class="col-lg-12">
                            <div id="currentImage">
                                <img :src="selectedImageUrl" class="w-100"/>

                                <div class="input-group py-2">
                                    <input
                                        type="text"
                                        class="form-control border-0 px-0 bg-transparent"
                                        v-model="selectedImageCaption"
                                        :placeholder="trans.posts.forms.editor.images.picker.uploader.caption.placeholder"
                                        ref="caption"/>
                                </div>

                                <div class="input-group py-2">
                                    <select
                                        class="custom-select border-0 px-0 bg-transparent"
                                        v-model="selectedImageLayout">
                                        <option value="default">
                                            {{ trans.posts.forms.editor.images.picker.uploader.layout.default }}
                                        </option>
                                        <option value="wide">
                                            {{ trans.posts.forms.editor.images.picker.uploader.layout.wide }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!unsplashImages.length" class="modal-footer">
                    <button
                        class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
                        @click="applyImage"
                        data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash"
    import Unsplash, {toJson} from 'unsplash-js'
    import InfiniteLoading from 'vue-infinite-loading'
    import vueFilePond from 'vue-filepond';
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

    export default {
        name: 'image-modal',

        components: {
            InfiniteLoading,
            FilePond
        },

        data() {
            return {
                myFiles: [],
                searchKeyword: '',
                unsplashKey: Canvas.unsplash,
                unsplashPage: 1,
                unsplashPerPage: 9,
                unsplashImages: [],
                infiniteId: +new Date(),
                isSearching: false,
                blot: null,
                selectedImageUrl: null,
                selectedImageLayout: 'default',
                selectedImageCaption: '',
                galleryModalClasses: [
                    'modal-xl',
                    'modal-dialog-scrollable'
                ],
                exceedsMaxUploadSize: false,
                uploadSizeErrorMessage: '',
                path: Canvas.path,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.$parent.$on('openingImageModal', data => {
                if (!_.isEmpty(data)) {
                    this.myFiles = !_.isEmpty(data.url) ? [data.url] : []
                    this.selectedImageCaption = data.caption
                    this.selectedImageUrl = data.url
                    this.selectedImageLayout = data.layout || 'default'
                    this.blot = data.existingBlot

                }

                this.isReady = true
            })
        },

        methods: {
            handleFilePondInit: function() {
                console.log('FilePond has initialized')

                // FilePond instance methods are available on `this.$refs.pond`
            },

            fetchUnsplashImages($state) {
                this.$refs.modal.classList.add(...this.galleryModalClasses)

                const unsplash = new Unsplash({accessKey: this.unsplashKey})
                unsplash.search.photos('beach', this.unsplashPage, this.unsplashPerPage)
                    .then(toJson)
                    .then(json => {
                        if (!_.isEmpty(json.results)) {
                            this.unsplashImages.push(...json.results)
                            this.unsplashPage += 1;
                            this.isSearching = false

                            $state.loaded()
                        } else {
                            $state.complete()
                        }
                    });
            },

            selectUnsplashImage(image) {
                const unsplash = new Unsplash({accessKey: this.unsplashKey});
                unsplash.photos.downloadPhoto(image);

                this.selectedUnsplashImage = image

                this.$emit('changed', {
                    url: this.selectedUnsplashImage.urls.regular,
                    caption:
                        this.trans.posts.forms.editor.images.picker.caption.by +
                        ' <a href="' +
                        this.selectedUnsplashImage.user.links.html +
                        '" target="_blank">' +
                        this.selectedUnsplashImage.user.name +
                        '</a> ' +
                        this.trans.posts.forms.editor.images.picker.caption.on +
                        ' <a href="https://unsplash.com" target="_blank">Unsplash</a>',
                })
            },

            uploadImage(event) {
                let file = event.target.files[0]
                let formData = new FormData()

                this.exceedsMaxUploadSize = false;

                formData.append('image', file, file.name)

                this.$emit('isUploading')

                this.request()
                    .post('/api/media/uploads', formData)
                    .then(response => {
                        this.$emit('changed', {
                            url: response.data,
                        })
                    })
                    .catch(error => {
                        // Add any error debugging...
                        this.exceedsMaxUploadSize = true;
                        this.uploadSizeErrorMessage = error.response.data
                    })
            },

            clear() {
                this.blot = null
                this.selectedImageUrl = null
                this.selectedImageLayout = 'default'
                this.selectedImageCaption = ''
            },

            updateImage({url, caption}) {
                this.selectedImageUrl = url
                this.selectedImageCaption = caption ? caption : ''
            },

            applyImage() {
                if (!this.selectedImageUrl) {
                    return
                }

                this.$emit('addingImage', {
                    url: this.selectedImageUrl,
                    caption: this.selectedImageCaption,
                    existingBlot: this.blot,
                    layout: this.selectedImageLayout,
                })

                this.clear()
            },

            resetComponent() {
                this.unsplashImages = []
                this.unsplashPage = 1
                this.searchKeyword = ''
                this.$refs.modal.classList.remove(...this.galleryModalClasses)
                this.$refs.modal.hide
            },
        },

        computed: {
            getServerOptions() {
                return {
                    url: this.getUploadPath,
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    }
                }
            },

            getUploadPath() {
                return '/' + this.path + '/api/media/uploads'
            },

            getPlaceholderLabel() {
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" class="icon-cloud-upload"><path class="secondary" d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"/><path class="secondary" d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"/></svg> Drop files or click here to upload'
            }
        }
    }
</script>

<style lang="scss">
    @import '../../../../resources/sass/variables';

    .filepond--file-action-button {
        cursor: pointer;
    }

    .filepond--drop-label {
        color: $gray-700;
    }

    .filepond--panel-root {
        background-color: $gray-500;
    }

    .filepond--panel-root {
        border-radius: $border-radius;
    }

    .filepond--item-panel {
        border-radius: $border-radius;
    }
</style>
