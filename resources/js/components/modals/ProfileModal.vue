<template>
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between border-0">
                    <h4 class="modal-title">{{ Canvas.user.name }}</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" class="icon-close-circle">
                            <circle cx="12" cy="12" r="10" class="primary"/>
                            <path class="fill-bg" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <file-pond
                        name="profileImagePond"
                        ref="pond"
                        max-files="1"
                        :label-idle="getPlaceholderLabel"
                        accepted-file-types="image/jpeg, image/png"
                        :server="getServerOptions"
                        :allow-multiple="false"
                        :files="selectedImagesForPond"
                        @processfile="processedFromFilePond"
                        @removefile="removedFromFilePond"/>

                    <input
                        hidden
                        type="file"
                        ref="file"
                        accept="image/*"
                    />
                    <div class="d-flex justify-content-center bg-black">
                        <img
                            :src="avatar"
                            class="w-50 rounded-circle shadow-inner my-3 h-100"
                            style="cursor:pointer"
                        />
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                Username
                            </label>
                            <input
                                name="username"
                                type="text"
                                :class="!Canvas.darkMode ? 'bg-light': 'bg-darker'"
                                class="form-control border-0"
                                title="Username"
                                v-model="username"
                                placeholder="Choose a username..."
                            />
                            <div v-if="form.errors.username" class="invalid-feedback d-block">
                                <strong>{{ form.errors.username[0] }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                Summary
                            </label>
                            <textarea
                                rows="4"
                                id="summary"
                                name="summary"
                                style="resize: none"
                                :class="!Canvas.darkMode ? 'bg-light': 'bg-darker'"
                                class="form-control border-0"
                                v-model="summary"
                                placeholder="Tell us a little bit about yourself...">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-lg order-lg-last px-0">
                            <a
                                href="#"
                                class="btn btn-success btn-block font-weight-bold mt-0"
                                aria-label="Save"
                                @click.prevent="clickSave">
                                {{ trans.buttons.general.save }}
                            </a>
                        </div>
                        <div class="col-lg order-lg-first px-0">
                            <button
                                class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                data-dismiss="modal">
                                {{ trans.buttons.general.cancel }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vueFilePond from 'vue-filepond'

    import 'filepond/dist/filepond.min.css'
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

    import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

    const FilePond = vueFilePond(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageValidateSize,
    );

    export default {
        name: 'profile-modal',

        props: {
            form: {
                type: Object,
                required: true,
            },
        },

        components: {
            FilePond
        },

        data() {
            return {
                selectedImagesForPond: [],
                username: this.form.username,
                summary: this.form.summary,
                avatar: this.form.avatar,
                path: Canvas.path,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            // let url = null
            this.dataUrl(this.avatar, function(base) {
                console.log(base)
            })

            // this.$refs.pond.addFile(url)
        },

        methods: {
            processedFromFilePond() {
                let imgUrl = document.getElementsByName('profileImagePond')[0].value

                this.isReadyToAcceptUploads = true
                this.avatar = imgUrl
                this.$root.$emit('updateAvatar', imgUrl)
            },

            removedFromFilePond() {
                this.isReadyToAcceptUploads = true
                this.selectedImagesForPond = []
                this.avatar = null
            },

            clickSave() {
                let data = {
                    username: this.username,
                    summary: this.summary,
                    avatar: this.avatar,
                }

                this.$parent.saveData(data, true)
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
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="35" class="icon-cloud-upload mr-3"><path class="secondary" d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"/><path class="secondary" d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"/></svg> Drop files or click here to upload'
            },
        }
    }
</script>

<style lang="scss">
    .bg-darker {
        background-color: #71809630;
    }
</style>
