<script type="text/ecmascript-6">
    import axios from 'axios'

    /**
     * Create the default image picker.
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        props: ['unsplash'],

        data() {
            return {
                url: '',
                selectedUnsplashImage: null,
                unsplashModalShown: false,
                unsplashSearchTerm: '',
                unsplashPage: 1,
                searchingUnsplash: true,
                unsplashImages: [],
                greeting: i18n.posts.forms.editor.images.picker.greeting,
                action: i18n.posts.forms.editor.images.picker.action,
                item: i18n.posts.forms.editor.images.picker.item,
                operator: i18n.posts.forms.editor.images.picker.operator,
                source: i18n.posts.forms.editor.images.picker.unsplash,
                key: i18n.posts.forms.editor.images.picker.key,
                placeholder: i18n.posts.forms.editor.images.picker.placeholder,
                empty: i18n.posts.forms.editor.images.picker.search.empty,
                next: i18n.buttons.general.next,
                cancel: i18n.buttons.general.cancel,
                captionBy: i18n.posts.forms.editor.images.picker.caption.by,
                captionOn: i18n.posts.forms.editor.images.picker.caption.on,
            }
        },

        watch: {
            unsplashSearchTerm() {
                this.getImagesFromUnsplash()
            }
        },

        methods: {
            // Get images from Unsplash
            getImagesFromUnsplash(page = 1) {
                if (!this.unsplash) {
                    return this.alertError(this.key);
                }
                this.unsplashPage = page;
                this.searchingUnsplash = true;
                axios.get('https://api.unsplash.com/search/photos?client_id=' + this.unsplash +
                    '&orientation=landscape&per_page=12' +
                    '&query=' + this.unsplashSearchTerm +
                    '&page=' + page
                ).then(response => {
                    this.unsplashImages = response.data.results;
                    this.searchingUnsplash = false;
                }).catch(error => {
                    let errors = error.response.data.errors;
                    this.searchingUnsplash = false;
                });
            },

            // Open the Unsplash modal
            openUnsplashModal() {
                if (document.querySelector('#featured-image-unsplash-modal')) {
                    document.querySelector('#featured-image-unsplash-modal').classList.add('modal-lg');
                }
                if (document.querySelector('#unsplash-modal')) {
                    document.querySelector('#unsplash-modal').classList.add('modal-lg');
                }
                if (document.querySelector('#current-image')) {
                    document.querySelector('#current-image').classList.add('d-none');
                }
                this.unsplashSearchTerm = 'work';
                this.unsplashModalShown = true;
                this.$nextTick(() => {
                    this.$refs.unsplashSearch.focus();
                })
            },

            // Select an Unsplash image
            closeUnsplashModalAndInsertImage(image) {
                this.selectedUnsplashImage = image;

                this.$emit('changed', {
                    url: this.selectedUnsplashImage.urls.regular,
                    caption: this.captionBy + ' <a href="' + this.selectedUnsplashImage.user.links.html + '" target="_blank">' + this.selectedUnsplashImage.user.name + '</a> ' + this.captionOn + ' <a href="https://unsplash.com" target="_blank">Unsplash</a>',
                });

                this.closeUnsplashModal();
            },

            // Close unsplash modal
            closeUnsplashModal() {
                if (document.querySelector('#featured-image-unsplash-modal')) {
                    document.querySelector('#featured-image-unsplash-modal').classList.remove('modal-lg');
                }
                if (document.querySelector('#unsplash-modal')) {
                    document.querySelector('#unsplash-modal').classList.remove('modal-lg');
                }
                if (document.querySelector('#current-image')) {
                    document.querySelector('#current-image').classList.remove('d-none');
                }
                this.unsplashSearchTerm = '';
                this.unsplashModalShown = false;
                this.selectedUnsplashImage = null;
            },

            // Upload the selected image
            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let formData = new FormData();

                formData.append('image', file, file.name);

                this.$emit('uploading');

                axios.post('/canvas/media/uploads', formData).then(response => {
                    this.$emit('changed', {url: response.data});
                }).catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>

<template>
    <div>
        <input hidden
               type="file"
               class="custom-file-input"
               :id="'imageUpload'+_uid"
               accept="image/*"
               v-on:change="uploadSelectedImage">
        <div class="mb-0">
            {{ this.greeting }} <label :for="'imageUpload'+_uid" class="text-primary" style="cursor:pointer;">{{
            this.action }}</label> {{ this.item }}
            <span v-if="this.unsplash">{{ this.operator }}</span>
            <a v-if="this.unsplash"
               href="#"
               @click.prevent="openUnsplashModal"
               class="text-primary">
                {{ this.source }}
            </a>
        </div>

        <div v-if="unsplashModalShown">
            <div class="container p-0">
                <input type="text"
                       class="form-control-lg form-control border-0 px-0"
                       v-if="this.unsplash"
                       v-model="unsplashSearchTerm"
                       ref="unsplashSearch"
                       :placeholder="this.placeholder">

                <div v-if="!searchingUnsplash && unsplashImages.length">
                    <div class="card-columns">
                        <div class="card border-0"
                             v-for="image in unsplashImages">
                            <img v-bind:src="image.urls.small"
                                 class="card-img"
                                 style="cursor: pointer"
                                 @click="closeUnsplashModalAndInsertImage(image)">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-link text-muted"
                                type="button"
                                @click="closeUnsplashModal"
                                v-on:submit.prevent="onSubmit">
                            {{ this.cancel }}
                        </button>
                        <button class="btn btn-sm btn-outline-primary"
                                type="button"
                                @click="getImagesFromUnsplash(unsplashPage + 1)"
                                v-if="unsplashImages.length == 12"
                                v-on:submit.prevent="onSubmit">
                            {{ this.next }}
                        </button>
                    </div>
                </div>

                <div v-if="!searchingUnsplash && !unsplashImages.length">
                    <h4 class="text-center py-4">{{ this.empty }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>
