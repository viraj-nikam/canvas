<template>
    <section>
        <page-header>
            <template slot="options">
                <div v-if="!creatingUser" class="dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link pr-0"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="25"
                            class="icon-dots-horizontal"
                        >
                            <path
                                class="fill-light-gray"
                                fill-rule="evenodd"
                                d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
                            />
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="#" class="dropdown-item text-danger" @click="showDeleteModal"> {{ trans.delete }} </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="d-flex justify-content-between mt-2 mb-4 align-items-center">
                    <div>
                        <h2 class="mt-2">
                            {{ title }}
                        </h2>
                        <p class="mt-2 text-secondary">
                            {{ trans.last_updated }} {{ moment(user.updated_at).fromNow() }}
                        </p>
                    </div>
                    <select
                        v-model="user.role"
                        id="role"
                        :disabled="isAuthProfile"
                        class="ml-auto w-auto custom-select border-0 bg-light"
                        name="locale"
                        @change="selectRole"
                    >
                        <option
                            :key="`${roleId}-${name}`"
                            v-for="(name, roleId) in settings.roles"
                            :value="roleId"
                            :selected="user.role === roleId"
                        >
                            {{ name }}
                        </option>
                    </select>
                </div>

                <div class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div v-if="!isAuthProfile" class="row">
                            <div class="col-lg-2 text-center text-lg-left">
                                <img
                                    :src="user.avatar"
                                    :alt="user.name"
                                    width="125"
                                    class="rounded-circle shadow-inner align-self-center"
                                />
                            </div>
                            <div class="col-lg-10 align-self-center text-center text-lg-left">
                                <p class="my-0 lead font-weight-bold">{{ user.name }}</p>
                                <p class="text-muted mb-1">
                                    <a :href="`mailto:${user.email}`" class="text-primary">{{ user.email }}</a>
                                    <span v-if="user.username"> ― @{{ user.username }}</span>
                                </p>
                                <p class="mb-0 text-muted">{{ user.summary }}</p>
                            </div>
                        </div>

                        <section v-if="isAuthProfile">
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
                                        <img
                                            :src="user.avatar || user.default_avatar"
                                            class="rounded-circle w-75 shadow-inner"
                                            :alt="user.name"
                                        />

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
                                            <label
                                                for="username"
                                                class="font-weight-bold text-uppercase text-muted small"
                                            >
                                                {{ trans.username }}
                                            </label>
                                            <input
                                                v-model="user.username"
                                                id="username"
                                                name="username"
                                                :disabled="!isAuthProfile"
                                                type="text"
                                                class="form-control border-0"
                                                :class="{ disabled: !isAuthProfile }"
                                                title="Username"
                                                :placeholder="trans.choose_a_username"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label
                                                for="summary"
                                                class="font-weight-bold text-uppercase text-muted small"
                                            >
                                                {{ trans.summary }}
                                            </label>
                                            <textarea
                                                v-model="user.summary"
                                                id="summary"
                                                rows="4"
                                                name="summary"
                                                :disabled="!isAuthProfile"
                                                style="resize: none"
                                                class="form-control border-0"
                                                :class="{ disabled: !isAuthProfile }"
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
                                        :disabled="!isAuthProfile"
                                        onclick="this.blur()"
                                        class="btn btn-success btn-block font-weight-bold mt-0"
                                        :class="{ disabled: !isAuthProfile }"
                                        aria-label="Save"
                                        @click.prevent="updateUser"
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
                        </section>
                    </div>
                </div>

                <h2 v-if="posts.length > 0" class="mt-5">{{ trans.posts }}</h2>

                <div v-if="posts.length > 0" class="mt-3 card shadow-lg">
                    <div class="card-body p-0">
                        <div :key="`${index}-${post.id}`" v-for="(post, index) in posts">
                            <router-link
                                :to="{
                                    name: 'edit-post',
                                    params: { id: post.id },
                                }"
                                class="text-decoration-none"
                            >
                                <div
                                    v-hover="{ class: `hover-bg` }"
                                    class="d-flex p-3 align-items-center"
                                    :class="{
                                        'border-top': index !== 0,
                                        'rounded-top': index === 0,
                                        'rounded-bottom': index === posts.length - 1,
                                    }"
                                >
                                    <div class="pl-2 col-md-6 col-sm-8 col-10">
                                        <p class="mb-0 mt-2 lead font-weight-bold text-truncate">
                                            {{ post.title }}
                                        </p>
                                        <p class="text-secondary mb-2">
                                            <span v-if="isPublished(post.published_at)">
                                                <span class="d-none d-md-inline"> {{ post.read_time }} ― </span>
                                                {{ trans.published }}
                                                {{ moment(post.published_at).format('MMM D, YYYY') }}
                                            </span>
                                            <span v-if="isDraft(post.published_at)">
                                                <span class="text-danger">{{ trans.draft }}</span>
                                                <span class="d-none d-md-inline">
                                                    ― {{ trans.updated }}
                                                    {{ moment(post.updated_at).fromNow() }}
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="d-none d-md-inline">
                                            <span class="text-secondary mr-3"
                                                >{{ suffixedNumber(post.views_count) }}
                                                {{ post.views_count == 1 ? trans.view : trans.views }}</span
                                            >
                                            <span class="mr-3"
                                                >{{ trans.created }}
                                                {{ moment(post.created_at).format('MMM D, YYYY') }}</span
                                            >
                                        </div>

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="25"
                                            viewBox="0 0 24 24"
                                            class="icon-cheveron-right-circle"
                                        >
                                            <circle cx="12" cy="12" r="10" style="fill: none" />
                                            <path
                                                class="fill-light-gray"
                                                d="M10.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <infinite-loading spinner="spiral" @infinite="fetchPosts">
                            <span slot="no-more" />
                            <div slot="no-results" />
                        </infinite-loading>
                    </div>
                </div>
            </div>
        </main>

        <delete-modal
            ref="deleteModal"
            :header="trans.delete"
            :message="trans.deleted_users_are_gone_forever"
            @delete="deleteUser"
        />
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
import DeleteModal from '../components/modals/DeleteModal';
import PageHeader from '../components/PageHeader';
import Hover from '../directives/Hover';
import url from '../mixins/url';
import status from '../mixins/status';
import vueFilePond from 'vue-filepond';
import $ from 'jquery';
import InfiniteLoading from 'vue-infinite-loading';
import isEmpty from 'lodash/isEmpty';
import strings from '../mixins/strings';

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
        DeleteModal,
        InfiniteLoading,
        PageHeader,
        FilePond,
    },

    directives: {
        Hover,
    },

    mixins: [url, status, strings],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            user: {},
            posts: [],
            page: 1,
            errors: [],
            selectedImagesForPond: [],
            isReadyToAcceptUploads: false,
            isReady: false,
        };
    },

    computed: {
        ...mapState(['settings', 'profile']),
        ...mapGetters({
            trans: 'settings/trans',
        }),

        isAuthProfile() {
            return this.profile.id === this.user.id;
        },

        creatingUser() {
            return this.$route.name === 'create-user';
        },

        getServerOptions() {
            return {
                url: `/${this.settings.path}/api/uploads`,
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
            };
        },

        getRetryIcon() {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-refresh" width="26"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M8.52 7.11a5.98 5.98 0 0 1 8.98 2.5 1 1 0 1 1-1.83.8 4 4 0 0 0-5.7-1.86l.74.74A1 1 0 0 1 10 11H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1.7-.7l.82.81zm5.51 8.34l-.74-.74A1 1 0 0 1 14 13h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1.7.7l-.82-.81A5.98 5.98 0 0 1 6.5 14.4a1 1 0 1 1 1.83-.8 4 4 0 0 0 5.7 1.85z"/></svg>';
        },

        getRemoveIcon() {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" class="icon-close-circle"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/></svg>';
        },

        getPlaceholderLabel() {
            return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="35" class="icon-cloud-upload"><path class="fill-dark-gray" d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"/><path class="fill-dark-gray" d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"/></svg><br/> ${this.trans.drop_files_or_click_to_upload}`;
        },

        title() {
            if (this.creatingUser) {
                return this.user.name || this.trans.new_user;
            } else {
                return this.user.name || this.trans.edit_user;
            }
        },
    },

    watch: {
        async $route(to) {
            this.isReady = false;
            this.uri = to.params.id;
            await Promise.all([this.fetchUser(), this.fetchPosts()]);
            this.isReady = true;
            NProgress.done();
        },
    },

    async created() {
        await Promise.all([this.fetchUser(), this.fetchPosts()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchUser() {
            this.request()
                .get(`/api/users/${this.uri}`)
                .then(({ data }) => {
                    this.user = data;
                })
                .catch(() => {
                    this.$router.push({ name: 'users' });
                });

            NProgress.inc();
        },

        fetchPosts($state) {
            return this.request()
                .get(`/api/users/${this.uri}/posts`, {
                    params: {
                        page: this.page,
                    },
                })
                .then(({ data }) => {
                    if (!isEmpty(data) && !isEmpty(data.data)) {
                        this.page += 1;
                        this.posts.push(...data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }

                    if (isEmpty($state)) {
                        NProgress.inc();
                    }
                })
                .catch(() => {
                    NProgress.done();
                });
        },

        processedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            this.user.avatar = document.getElementsByName('profileImagePond')[0].value;
        },

        removedFromFilePond() {
            this.isReadyToAcceptUploads = true;
            this.user.avatar = null;
            this.selectedImagesForPond = [];
        },

        updateUser() {
            this.request()
                .post(`/api/users/${this.user.id}`, {
                    username: payload.username,
                    summary: payload.summary,
                    avatar: payload.avatar,
                })
                .then(({ data }) => {
                    this.user = data.user;
                    this.$toasted.show(this.trans.saved, {
                        className: 'bg-success',
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.$toasted.show(error.response.data.errors.username[0], {
                        className: 'bg-danger',
                    });
                });
        },

        clearAvatar() {
            this.user.avatar = this.user.default_avatar;
            this.isReadyToAcceptUploads = true;
        },

        selectRole() {
            this.request()
                .post(`/api/users/${this.user.id}`, {
                    role: this.user.role,
                })
                .then(() => {
                    this.$toasted.show(this.trans.saved, {
                        className: 'bg-success',
                    });
                });
        },

        async deleteUser() {
            await this.request()
                .delete(`/api/users/${this.uri}`)
                .then(() => {
                    this.$store.dispatch('search/buildIndex', true);
                    this.$toasted.show(this.trans.success, {
                        className: 'bg-success',
                    });
                });

            $(this.$refs.deleteModal.$el).modal('hide');

            await this.$router.push({ name: 'users' });
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
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
