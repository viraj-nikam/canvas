<template>
    <div>
        <page-header>
            <template slot="status">
                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <span v-if="user.isSaving">{{ i18n.saving }}</span>
                        <span v-if="user.hasSuccess" class="text-success">{{ i18n.saved }}</span>
                    </li>
                </ul>
            </template>
        </page-header>

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="d-flex justify-content-between my-3">
                    <h1>{{ i18n.your_profile }}</h1>
                </div>

                <div class="mt-2 card shadow" :class="borderColor" v-if="isReady">
                    <div class="card-body p-0">
                        <div class="d-flex p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-1 font-weight-bold text-lg lead">
                                    {{ i18n.your_profile }}
                                </p>
                                <p class="mb-1 d-none d-lg-block">
                                    {{ i18n.choose_a_unique_username }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <button
                                        class="btn btn-sm btn-outline-success font-weight-bold"
                                        @click="showProfileModal"
                                    >
                                        {{ i18n.edit_profile }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex border-top p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-1 font-weight-bold text-lg lead">
                                    {{ i18n.weekly_digest }}
                                </p>
                                <p class="mb-1 d-none d-lg-block">
                                    {{ i18n.toggle_digest }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group my-auto">
                                        <span class="switch switch-sm">
                                            <input
                                                type="checkbox"
                                                class="switch"
                                                id="digest"
                                                @change="toggleDigest"
                                                :checked="user.digest"
                                                v-model="user.digest"
                                            />
                                            <label for="digest" class="mb-0 sr-only">
                                                {{ i18n.weekly_digest }}
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex border-top p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-1 font-weight-bold text-lg lead">
                                    {{ i18n.dark_mode }}
                                </p>
                                <p class="mb-1 d-none d-lg-block">
                                    {{ i18n.toggle_dark_mode }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group my-auto">
                                        <span class="switch switch-sm">
                                            <input
                                                type="checkbox"
                                                class="switch"
                                                id="darkMode"
                                                @change="toggleDarkMode"
                                                :checked="user.darkMode"
                                                v-model="user.darkMode"
                                            />
                                            <label for="darkMode" class="mb-0 sr-only">
                                                {{ i18n.dark_mode }}
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex border-top p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-1 font-weight-bold text-lg lead">
                                    {{ i18n.locale }}
                                </p>
                                <p class="mb-1 d-none d-lg-block">
                                    {{ i18n.select_your_language_or_region }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group row mt-3">
                                        <div class="col-12">
                                            <select
                                                :class="bgColor"
                                                class="custom-select border-0"
                                                @change="updateLocale"
                                                v-model="user.locale"
                                                name="locale"
                                            >
                                                <option
                                                    v-for="(locale, code) in config.languageCodes"
                                                    :key="code"
                                                    :value="code"
                                                    :selected="user.locale === code"
                                                >
                                                    {{ locale }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <profile-modal v-if="isReady" ref="profileModal" />
    </div>
</template>

<script>
import $ from 'jquery';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import ProfileModal from '../components/modals/ProfileModal';
import strings from '../mixins/strings';
import i18n from '../mixins/i18n';
import store from '../store';

export default {
    name: 'edit-settings',

    components: {
        PageHeader,
        ProfileModal,
    },

    mixins: [strings, i18n],

    data() {
        return {
            isReady: false,
        };
    },

    async created() {
        await store.dispatch('user/fetchUser', this.user.id);

        NProgress.done();
        this.isReady = true;
    },

    computed: {
        user() {
            return store.state.user;
        },

        config() {
            return store.state.config;
        },

        bgColor() {
            return store.state.user.darkMode ? 'bg-darker' : 'bg-light';
        },

        borderColor() {
            return store.state.user.darkMode ? 'border-0' : '';
        },
    },

    methods: {
        toggleDigest() {
            store.dispatch('user/updateUser', this.user);
        },

        updateLocale() {
            store.dispatch('config/updateI18n', this.user.locale);
            store.dispatch('user/updateUser', this.user);
        },

        toggleDarkMode() {
            let screen = $('#canvas');

            screen.animate(
                {
                    opacity: 0,
                    backgroundColor: 'rgb(38, 50, 56)',
                },
                300,
                function () {
                    if (store.state.user.darkMode) {
                        $('#baseStylesheet').attr('href', '/vendor/canvas/css/app-dark.css');
                        $('#highlightStylesheet').attr(
                            'href',
                            '//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/styles/sunburst.min.css'
                        );
                    } else {
                        $('#baseStylesheet').attr('href', '/vendor/canvas/css/app.css');
                        $('#highlightStylesheet').attr(
                            'href',
                            '//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/styles/github.min.css'
                        );
                    }
                }
            );

            store.dispatch('user/updateUser', this.user);

            screen.animate(
                {
                    opacity: 1,
                    backgroundColor: 'rgb(38, 50, 56)',
                },
                300,
                function () {}
            );
        },

        showProfileModal() {
            $(this.$refs.profileModal.$el).modal('show');
        },
    },
};
</script>
