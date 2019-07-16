<template>
    <div v-cloak>
        <div v-if="this.$parent.imageUrl">
            <a href="#" @click="clearSelectedImage">
                {{ trans.posts.forms.editor.images.picker.clear.action }}
            </a>
            {{ trans.posts.forms.editor.images.picker.clear.description }}
        </div>

        <div v-else>
            <input hidden
                   type="file"
                   class="custom-file-input"
                   :id="'imageUpload'+_uid"
                   accept="image/*"
                   @change="uploadSelectedImage">
            <div class="mb-0">
                {{ trans.posts.forms.editor.images.picker.greeting }} <label :for="'imageUpload'+_uid" class="text-primary" style="cursor:pointer;">
                {{ trans.posts.forms.editor.images.picker.action }}</label> {{ trans.posts.forms.editor.images.picker.item }}
                <span v-if="unsplashKey">{{ trans.posts.forms.editor.images.picker.operator }}</span>
                <a v-if="unsplashKey"
                   href="#"
                   @click.prevent="openUnsplashModal"
                   class="text-primary">
                    {{ trans.posts.forms.editor.images.picker.unsplash }}
                </a>
            </div>
        </div>

        <div v-if="showUnsplashModal">
            <div class="container p-0">
                <input type="text"
                       class="form-control-lg form-control border-0 px-0"
                       v-if="unsplashKey"
                       v-model="unsplashSearchTerm"
                       ref="unsplashSearch"
                       :placeholder="trans.posts.forms.editor.images.picker.placeholder">

                <div v-if="!searchingUnsplash && unsplashImages.length">
                    <div class="card-columns">
                        <div class="card border-0"
                             v-for="image in unsplashImages">
                            <img :src="image.urls.small"
                                 class="card-img"
                                 style="cursor: pointer"
                                 @click="closeUnsplashModalAndInsertImage(image)">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-link text-muted"
                                type="button"
                                @click="closeUnsplashModal"
                                @submit.prevent="onSubmit">
                            {{ trans.buttons.general.cancel }}
                        </button>
                        <button class="btn btn-sm btn-outline-primary"
                                type="button"
                                @click="getImagesFromUnsplash(unsplashPage + 1)"
                                v-if="unsplashImages.length === 12"
                                @submit.prevent="onSubmit">
                            {{ trans.buttons.general.next }}
                        </button>
                    </div>
                </div>

                <div v-if="!searchingUnsplash && !unsplashImages.length">
                    <h4 class="text-center py-4">{{ trans.posts.forms.editor.images.picker.search.empty }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery';

    /**
     * Create the default image picker.
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: 'image-picker',

        data() {
            return {
                url: '',
                selectedUnsplashImage: null,
                unsplashModalShown: false,
                unsplashSearchTerm: '',
                unsplashPage: 1,
                searchingUnsplash: true,
                unsplashImages: [],
                basePath: Canvas.path,
                unsplashKey: Canvas.unsplash,
                trans: JSON.parse(Canvas.lang),
            }
        },

        watch: {
            unsplashSearchTerm() {
                this.getImagesFromUnsplash()
            }
        },

        methods: {
            getImagesFromUnsplash(page = 1) {
                if (!this.unsplash) {
                    return this.alertError(this.trans.posts.forms.editor.images.picker.key);
                }

                // todo: add a message about using the key

                this.unsplashPage = page;
                this.searchingUnsplash = true;

                this.request()
                    .get('https://api.unsplash.com/search/photos?client_id='
                        + this.unsplash
                        + '&orientation=landscape&per_page=12'
                        + '&query=' + this.unsplashSearchTerm
                        + '&page=' + page)
                    .then((response) => {
                        this.unsplashImages = response.data.results;
                        this.searchingUnsplash = false;
                    })
                    .catch((error) => {
                        let errors = error.response.data.errors;

                        this.searchingUnsplash = false;
                    });
            },

            openUnsplashModal() {
                let featuredImageUnsplashModal = $('#featuredImageUnsplashModal');
                let unsplashModal = $('#unsplashModal');
                let currentImage = $('#currentImage');

                if (featuredImageUnsplashModal) {
                    featuredImageUnsplashModal.classList.add('modal-lg');
                }
                if (unsplashModal) {
                    unsplashModal.classList.add('modal-lg');
                }
                if (currentImage) {
                    currentImage.classList.add('d-none');
                }

                this.unsplashSearchTerm = 'work';
                this.showUnsplashModal = true;

                this.$nextTick(() => {
                    this.$refs.unsplashSearch.focus();
                })
            },

            closeUnsplashModalAndInsertImage(image) {
                this.selectedUnsplashImage = image;

                this.$emit('changed', {
                    url: this.selectedUnsplashImage.urls.regular,
                    caption: this.trans.posts.forms.editor.images.picker.caption.by + ' <a href="' + this.selectedUnsplashImage.user.links.html + '" target="_blank">' + this.selectedUnsplashImage.user.name + '</a> ' + this.trans.posts.forms.editor.images.picker.caption.on + ' <a href="https://unsplash.com" target="_blank">Unsplash</a>',
                });

                this.closeUnsplashModal();
            },

            closeUnsplashModal() {
                let featuredImageUnsplashModal = $('#featuredImageUnsplashModal');
                let unsplashModal = $('#unsplashModal');
                let currentImage = $('#currentImage');

                if (featuredImageUnsplashModal) {
                    featuredImageUnsplashModal.classList.remove('modal-lg');
                }
                if (unsplashModal) {
                    unsplashModal.classList.remove('modal-lg');
                }
                if (currentImage) {
                    currentImage.classList.remove('d-none');
                }

                this.unsplashSearchTerm = '';
                this.showUnsplashModal = false;

                this.selectedUnsplashImage = null;
            },

            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let formData = new FormData();

                formData.append('image', file, file.name);

                this.$emit('uploading');

                this.request()
                    .post('/api/media/uploads', formData)
                    .then((response) => {
                        this.$emit('changed', {url: response.data});
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            clearSelectedImage(event) {
                  this.$parent.imageUrl = '';
            },
        }
    }
</script>
