<script type="text/ecmascript-6">
    import axios from 'axios';

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
            }
        },

        watch: {
            unsplashSearchTerm() {
                this.getImagesFromUnsplash()
                // debouncer: _.debounce(callback => callback(), 500)
                // this.debouncer(() => {
                //     this.getImagesFromUnsplash();
                // });
            }
        },

        methods: {
            // Get images from Unsplash
            getImagesFromUnsplash(page = 1) {
                if (!this.unsplash) {
                    return this.alertError('Please configure your Unsplash API Key.');
                }
                this.unsplashPage = page;
                this.searchingUnsplash = true;
                axios.get('https://api.unsplash.com/search/photos?client_id=' + this.unsplash +
                    '&orientation=landscape&per_page=5' +
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
                document.querySelector('#test').classList.add('modal-lg');
                this.unsplashSearchTerm = 'city';
                this.unsplashModalShown = true;
                this.$nextTick(() => {
                    this.$refs.unsplashSearch.focus();
                })
            },

            // Select an Unsplash image
            closeUnsplashModalAndInsertImage() {
                this.$emit('changed', {
                    url: this.selectedUnsplashImage.urls.regular,
                    caption: 'Photo by <a href="' + this.selectedUnsplashImage.user.links.html + '">' + this.selectedUnsplashImage.user.name + '</a> on <a href="https://unsplash.com">Unsplash</a>',
                });
                this.closeUnsplashModal();
            },

            // Close unsplash modal
            closeUnsplashModal() {
                document.querySelector('#test').classList.remove('modal-lg');
                this.unsplashSearchTerm = '';
                this.unsplashModalShown = false;
                this.selectedUnsplashImage = null;
            },

            // Creates a debounced function that delays invoking a callback
            // debouncer() {
            //     return _.debounce(callback => callback(), 500);
            // },

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
        <input hidden
               type="file"
               class="custom-file-input"
               :id="'imageUpload'+_uid"
               accept="image/*"
               v-on:change="uploadSelectedImage">
        <div class="mb-0">
            Please <label :for="'imageUpload'+_uid" class="text-primary" style="cursor:pointer;">upload</label> an image
            <span v-if="this.unsplash">or</span>
            <a v-if="this.unsplash" href="#" @click.prevent="openUnsplashModal" class="text-text-color">search Unsplash</a>
        </div>

        <div v-if="unsplashModalShown">
            <div class="bg-contrast z-50 fixed pin overflow-y-scroll">
                <div class="container py-20">
                    <div class="flex items-center">
                        <h2 class="mr-auto">Search Unsplash</h2>

                        <button class="btn-primary mr-4" v-on:submit.prevent="onSubmit" v-if="selectedUnsplashImage" @click="closeUnsplashModalAndInsertImage">Choose Selected Image</button>
                        <button class="btn-light" v-on:submit.prevent="onSubmit" @click="closeUnsplashModal">Cancel</button>
                    </div>

                    <input type="text" class="my-10 border-b border-very-light focus:outline-none w-full"
                           v-if="this.unsplash"
                           v-model="unsplashSearchTerm"
                           ref="unsplashSearch"
                           placeholder="search Unsplash">

                    <!--<preloader v-if="searchingUnsplash" class="mt-10"></preloader>-->

                    <div v-if="!searchingUnsplash && unsplashImages.length" class="flex flex-wrap mt-5">
                        <div class="w-1/4 p-1 cursor-pointer" v-for="image in unsplashImages" @click="selectedUnsplashImage = image">
                            <div class="h-48 w-full bg-cover border-primary"
                                 :class="{'border-4': selectedUnsplashImage && selectedUnsplashImage.id == image.id}"
                                 :style="{ backgroundImage: 'url(' + image.urls.thumb + ')' }"></div>
                        </div>

                        <div class="w-1/4 p-1" v-if="unsplashImages.length == 5">
                            <div class="bg-primary text-center flex items-center justify-center h-full">
                                <button class="text-contrast hover:underline" @click="getImagesFromUnsplash(unsplashPage + 1)">More >></button>
                            </div>
                        </div>
                    </div>

                    <div v-if="!searchingUnsplash && !unsplashImages.length">
                        <h4 class="text-center">We couldn't find any matches.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>