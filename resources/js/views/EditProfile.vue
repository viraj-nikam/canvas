<template>
    <div>
        <page-header></page-header>

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="d-flex justify-content-between my-3">
                    <h1>Profile</h1>
                </div>

                <div class="mt-2 card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 order-md-last my-auto">
                                <file-pond
                                    v-if="isReadyToAcceptUploads"
                                    name="profileImagePond"
                                    ref="pond"
                                    max-files="1"
                                    :maxFileSize="config.maxUpload"
                                    :iconRemove="getRemoveIcon"
                                    :iconRetry="getRetryIcon"
                                    :label-idle="getPlaceholderLabel"
                                    className="w-75"
                                    accepted-file-types="image/*"
                                    imagePreviewHeight="170"
                                    imageCropAspectRatio="1:1"
                                    imageResizeTargetWidth="200"
                                    imageResizeTargetHeight="200"
                                    stylePanelLayout="compact circle"
                                    styleLoadIndicatorPosition="center bottom"
                                    styleProgressIndicatorPosition="center bottom"
                                    styleButtonProcessItemPosition="center bottom"
                                    styleButtonRemoveItemPosition="center bottom"
                                    :server="getServerOptions"
                                    :allow-multiple="false"
                                    :files="selectedImagesForPond"
                                    @processfile="processedFromFilePond"
                                    @removefile="removedFromFilePond"
                                />

                                <div v-if="!isReadyToAcceptUploads" class="text-center rounded p-3">
                                    <img :src="user.avatar" class="rounded-circle w-75 shadow-inset" />

                                    <p class="mt-3 mb-0">
                                        <a
                                            href=""
                                            @click.prevent="clearAvatar"
                                            class="text-decoration-none text-success"
                                            >Clear avatar</a
                                        >
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8 order-md-first my-auto">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ i18n.username }}
                                        </label>
                                        <input
                                            name="username"
                                            type="text"
                                            class="form-control border-0"
                                            title="Username"
                                            v-model="user.username"
                                            :placeholder="i18n.choose_a_username"
                                        />
                                        <div v-if="usernameValidationError" class="invalid-feedback d-block">
                                            <strong v-for="value in usernameValidationError" :key="`${value}`">{{
                                                value
                                            }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ i18n.summary }}
                                        </label>
                                        <textarea
                                            rows="4"
                                            id="summary"
                                            name="summary"
                                            style="resize: none;"
                                            class="form-control border-0"
                                            v-model="user.summary"
                                            :placeholder="i18n.tell_us_about_yourself"
                                        >
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-2">
                            <div class="col-md">
                                <a
                                    href="#"
                                    onclick="this.blur()"
                                    class="btn btn-success btn-block font-weight-bold mt-0"
                                    aria-label="Save"
                                    @click.prevent="updateProfile"
                                >
                                    {{ i18n.save }}
                                </a>
                            </div>
                            <div class="col-md">
                                <router-link
                                    :to="{ name: 'all-stats' }"
                                    class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                >
                                    {{ i18n.cancel }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import PageHeader from '../components/PageHeader';
import NProgress from 'nprogress';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import i18n from '../mixins/i18n';
import store from '../store';
import get from 'lodash/get';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation
);

export default {
    name: 'edit-profile',

    components: {
        PageHeader,
        FilePond,
    },

    mixins: [i18n],

    data() {
        return {
            selectedImagesForPond: [],
            isReadyToAcceptUploads: false,
        };
    },

    mounted() {
        NProgress.done();
    },

    computed: {
        user() {
            return store.state.user;
        },

        config() {
            return store.state.config;
        },

        getServerOptions() {
            return {
                url: '/' + this.config.path + '/api/uploads',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
            };
        },

        usernameValidationError() {
            let errors = Object.values(this.user.errors);

            return get(errors.flat(1), '[0].username', null);
        },

        getRetryIcon() {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-refresh" width="26"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M8.52 7.11a5.98 5.98 0 0 1 8.98 2.5 1 1 0 1 1-1.83.8 4 4 0 0 0-5.7-1.86l.74.74A1 1 0 0 1 10 11H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1.7-.7l.82.81zm5.51 8.34l-.74-.74A1 1 0 0 1 14 13h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1.7.7l-.82-.81A5.98 5.98 0 0 1 6.5 14.4a1 1 0 1 1 1.83-.8 4 4 0 0 0 5.7 1.85z"/></svg>';
        },

        getRemoveIcon() {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" class="icon-close-circle"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/></svg>';
        },

        getPlaceholderLabel() {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="35" class="icon-cloud-upload"><path class="fill-dark-gray" d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"/><path class="fill-dark-gray" d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"/></svg><br/> Drop files or click here to upload';
        },
    },

    methods: {
        processedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            store.dispatch('user/setAvatar', document.getElementsByName('profileImagePond')[0].value);
        },

        removedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            this.selectedImagesForPond = [];
            store.dispatch('user/setDefaultAvatar');
        },

        updateProfile() {
            store.dispatch('user/updateUser', this.user);
        },

        clearAvatar() {
            store.dispatch('user/setDefaultAvatar');
            this.isReadyToAcceptUploads = true;
        },
    },
};
</script>

<style scoped lang="scss">
.filepond--wrapper {
    display: flex;
    justify-content: center;
}

.filepond--root {
    margin-bottom: 0;
}
</style>
