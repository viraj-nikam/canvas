<template>
    <div v-cloak>
        <div v-if="unsplashKey">
            <div class="input-group border-bottom">
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

            <div v-if="unsplashImages.length">
                <div class="card-columns mt-3">
                    <div v-for="(image, $index) in unsplashImages" :key="$index" class="card border-0">
                        <img
                            :src="image.urls.small"
                            :alt="image.alt_description"
                            class="card-img"
                            style="cursor: pointer"
                            @click="closeUnsplashAndInsertImage(image)"
                        />
                    </div>
                </div>

                <infinite-loading :identifier="infiniteId" @infinite="fetchImages" spinner="spiral">
                        <span slot="no-more">
                            no more to load :)
                        </span>
                    <div slot="no-results"></div>
                </infinite-loading>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash"
    import Unsplash, {toJson} from 'unsplash-js'
    import InfiniteLoading from 'vue-infinite-loading'

    export default {
        name: 'image-picker',

        components: {
            InfiniteLoading
        },

        data() {
            return {
                searchKeyword: '',
                unsplashKey: Canvas.unsplash,
                page: 1,
                perPage: 12,
                unsplashImages: [],
                infiniteId: +new Date(),
                isSearching: false,
                selectedUnsplashImage: null,
                exceedsMaxUploadSize: false,
                uploadSizeErrorMessage: '',
                path: Canvas.path,
                trans: JSON.parse(Canvas.lang),
            }
        },

        watch: {
            searchKeyword: _.debounce(function (e) {
                this.fetchImages()
            }, 1000),
        },

        methods: {
            fetchImages($state) {
                console.log($state)
                let modalClasses = ['modal-xl', 'modal-dialog-scrollable']
                this.$parent.$refs.modal.classList.add(...modalClasses)
                this.isSearching = true

                const unsplash = new Unsplash({accessKey: this.unsplashKey})
                unsplash.search.photos(this.searchKeyword, this.page, this.perPage)
                    .then(toJson)
                    .then(json => {
                        if (!_.isEmpty(json.results)) {
                            this.unsplashImages.push(...json.results)
                            this.isSearching = false
                            this.page += 1;

                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            },

            closeUnsplashAndInsertImage(image) {
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

                this.closeUnsplash()
            },

            closeUnsplash() {
                let featuredImageModal = document.querySelector(
                    '#featuredImageModal'
                )
                if (featuredImageModal) {
                    featuredImageModal.classList.remove('modal-lg')
                }

                let imageModal = document.querySelector('#imageModal')
                if (imageModal) {
                    imageModal.classList.remove('modal-lg')
                }

                let currentImage = document.querySelector('#currentImage')
                if (currentImage) {
                    currentImage.classList.remove('d-none')
                }

                this.searchKeyword = ''
                this.showUnsplash = false
                this.selectedUnsplashImage = null
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
        },
    }
</script>
