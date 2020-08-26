<template>
    <section>
        <page-header />

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="my-3">
                    <h2 class="mt-3">
                        {{ isAuthUserProfile ? trans.edit_profile : 'Edit user' }}
                    </h2>
                    <p class="mt-2 text-secondary">{{ trans.last_updated }} {{ moment(activeUser.updatedAt).fromNow() }}</p>
                </div>

                <div v-if="isAuthUserProfile" class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 order-md-last my-auto">
                                <file-pond
                                    ref="pond"
                                    v-if="isReadyToAcceptUploads"
                                    name="profileImagePond"
                                    max-files="1"
                                    :max-file-size="settings.maxUpload"
                                    :icon-remove="getRemoveIcon"
                                    :icon-retry="getRetryIcon"
                                    :label-idle="getPlaceholderLabel"
                                    class-name="w-75"
                                    accepted-file-types="image/*"
                                    image-preview-height="170"
                                    image-crop-aspect-ratio="1:1"
                                    image-resize-target-width="200"
                                    image-resize-target-height="200"
                                    style-panel-layout="compact circle"
                                    style-load-indicator-position="center bottom"
                                    style-progress-indicator-position="center bottom"
                                    style-button-process-item-position="center bottom"
                                    style-button-remove-item-position="center bottom"
                                    :server="getServerOptions"
                                    :allow-multiple="false"
                                    :files="selectedImagesForPond"
                                    @processfile="processedFromFilePond"
                                    @removefile="removedFromFilePond"
                                />

                                <div v-if="!isReadyToAcceptUploads" class="text-center rounded p-3">
                                    <img :src="avatarPath" class="rounded-circle w-75 shadow-inner" :alt="activeUser.name" />

                                    <p class="mt-3 mb-0">
                                        <a
                                            href=""
                                            class="text-decoration-none text-success"
                                            @click.prevent="clearAvatar"
                                            >Clear avatar</a
                                        >
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8 order-md-first my-auto">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.username }}
                                        </label>
                                        <input
                                            v-model="username"
                                            name="username"
                                            :disabled="!isAuthUserProfile"
                                            type="text"
                                            class="form-control border-0"
                                            :class="{ disabled: !isAuthUserProfile }"
                                            title="Username"
                                            :placeholder="trans.choose_a_username"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.summary }}
                                        </label>
                                        <textarea
                                            v-model="summary"
                                            id="summary"
                                            rows="4"
                                            name="summary"
                                            :disabled="!isAuthUserProfile"
                                            style="resize: none;"
                                            class="form-control border-0"
                                            :class="{ disabled: !isAuthUserProfile }"
                                            :placeholder="trans.tell_us_about_yourself"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-2">
                            <div class="col-md">
                                <a
                                    href="#"
                                    :disabled="!isAuthUserProfile"
                                    onclick="this.blur()"
                                    class="btn btn-success btn-block font-weight-bold mt-0"
                                    :class="{ disabled: !isAuthUserProfile }"
                                    aria-label="Save"
                                    @click.prevent="updateProfile"
                                >
                                    {{ trans.save }}
                                </a>
                            </div>
                            <div class="col-md">
                                <router-link
                                    :to="{ name: 'stats' }"
                                    class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                >
                                    {{ trans.cancel }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="!isAuthUserProfile">
                    Yay!
                </div>

                <div class="mt-5">
                    <h2 class="mt-3">{{ trans.role }}</h2>
                </div>

                <div class="mt-3 card shadow-lg">
                    <div class="card-body p-0">
                        <div class="d-flex rounded-top p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-0 lead font-weight-bold">
                                    {{ trans.admin }}
                                </p>
                                <p class="mb-1 d-none d-lg-block text-secondary">
                                    {{ trans.grant_this_user_admin_privileges }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group my-auto">
                                        <span class="switch switch-sm">
                                            <input
                                                v-model="activeUser.admin"
                                                id="admin"
                                                type="checkbox"
                                                class="switch"
                                                :disabled="isAuthUserProfile"
                                                :checked="activeUser.admin"
                                                @change="toggleAdmin"
                                            />
                                            <label for="admin" class="mb-0 sr-only">
                                                {{ trans.grant_this_user_admin_privileges }}
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</template>

<script>
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';
import { mapGetters, mapState } from 'vuex';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import url from '../mixins/url';
import vueFilePond from 'vue-filepond';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation
);

export default {
    name: 'edit-user',

    components: {
        PageHeader,
        FilePond,
    },

    mixins: [url],

    data() {
        return {
            uri: this.$route.params.id,
            username: '',
            summary: '',
            avatar: '',
            selectedImagesForPond: [],
            isReadyToAcceptUploads: false,
            isReady: false,
        };
    },

    computed: {
        ...mapState(['settings', 'profile']),
        ...mapGetters({
            activeUser: 'user/activeUser',
            trans: 'settings/trans',
        }),

        userLastUpdated() {
            return this.activeUser.updatedAt;
        },

        avatarPath() {
            return this.activeUser.avatar;
            // return this.avatar || url.methods.gravatar(this.user.email);
        },

        isAuthUserProfile() {
            return this.profile.id === this.activeUser.id;
        },

        getServerOptions() {
            return {
                url: `/${this.settings.path}/api/uploads`,
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
            };
        },

        usernameValidationError() {
            // if (this.user.errors) {
            //     let errors = Object.values(this.user.errors);
            //
            //     return get(errors.flat(1), '[0].username', null);
            // }

            return [];
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

    // watch: {
    //     $route(to) {
    //         this.isReady = false;
    //         this.user = null;
    //         this.username = null;
    //         this.summary = null;
    //         this.avatar = null;
    //         this.meta = null;
    //         this.fetchUser(to.params.id);
    //         this.isReady = true;
    //         NProgress.done();
    //     },
    // },

    async created() {
        await Promise.all([this.fetchUser()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchUser() {
            this.$store.dispatch('user/fetchUser', this.uri);
            NProgress.inc();
            // return this.request()
            //     .get(`/api/users/${this.uri}`)
            //     .then(({ data }) => {
            //         this.user = data.user;
            //         this.meta = data.meta;
            //         this.summary = get(data.meta, 'summary', null);
            //         this.username = get(data.meta, 'username', null);
            //         this.avatar = get(data.meta, 'avatar', null);
            //     });
        },

        processedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            this.avatar = document.getElementsByName('profileImagePond')[0].value;
        },

        removedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            this.avatar = null;
            this.selectedImagesForPond = [];
        },

        updateProfile() {
            // this.request()
            //     .post(`/api/users/${this.user.id}`, { ...this.user, ...this.meta })
            //     .then(({ data }) => {
            //         this.user = data.user;
            //         this.summary = data.meta.summary;
            //         this.username = data.meta.username;
            //         this.avatar = data.meta.avatar;
            //
            //         this.$store.dispatch('auth/setAvatar', data.meta.avatar);
            //
            //         this.$toasted.show(this.trans.saved, {
            //             className: 'bg-success',
            //         });
            //     })
            //     .catch((errors) => {
            //         console.log(errors);
            //     });
        },

        clearAvatar() {
            this.avatar = url.methods.gravatar(this.user.email);
            this.isReadyToAcceptUploads = true;
        },

        toggleAdmin() {
            // this.request()
            //     .post(`/api/users/${this.user.id}`, { ...this.user, ...this.meta })
            //     .then(({ data }) => {
            //         this.user = data.user;
            //     })
            //     .catch((errors) => {
            //         console.log(errors);
            //     });
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
