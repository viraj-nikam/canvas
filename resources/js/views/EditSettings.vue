<template>
    <div>
        <page-header />

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="my-3">
                    <h2 class="mt-3">{{ i18n.settings }}</h2>
                </div>

                <div v-if="isReady" class="mt-5 card shadow-lg">
                    <div class="card-body p-0">
                        <div class="d-flex rounded-top p-3 align-items-center">
                            <div class="mr-auto py-1">
                                <p class="mb-0 lead font-weight-bold">
                                    {{ i18n.weekly_digest }}
                                </p>
                                <p class="mb-1 d-none d-lg-block text-secondary">
                                    {{ i18n.toggle_digest }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group my-auto">
                                        <span class="switch switch-sm">
                                            <input
                                                v-model="auth.digest"
                                                id="digest"
                                                type="checkbox"
                                                class="switch"
                                                :checked="auth.digest"
                                                @change="toggleDigest"
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
                                <h5 class="mb-1">
                                    {{ i18n.dark_mode }}
                                </h5>
                                <p class="mb-1 d-none d-lg-block text-secondary">
                                    {{ i18n.toggle_dark_mode }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group my-auto">
                                        <span class="switch switch-sm">
                                            <input
                                                v-model="auth.darkMode"
                                                id="darkMode"
                                                type="checkbox"
                                                class="switch"
                                                :checked="auth.darkMode"
                                                @change="toggleDarkMode"
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
                                <h5 class="mb-1">
                                    {{ i18n.locale }}
                                </h5>
                                <p class="mb-1 d-none d-lg-block text-secondary">
                                    {{ i18n.select_your_language_or_region }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="align-middle">
                                    <div class="form-group row mt-3">
                                        <div class="col-12">
                                            <select
                                                v-model="auth.locale"
                                                class="custom-select border-0"
                                                name="locale"
                                                @change="selectLocale"
                                            >
                                                <option
                                                    :key="code"
                                                    v-for="code in config.languageCodes"
                                                    :value="code"
                                                    :selected="auth.locale === code"
                                                >
                                                    {{ getLocaleDisplayName(code) }}
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

        <div class="mt-3 d-flex justify-content-center">
            <a :href="latestRelease.link" class="text-muted text-decoration-none">
                {{ latestRelease.tag }}
            </a>
        </div>
    </div>
</template>

<script>
import Hover from '../directives/Hover';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import i18n from '../mixins/i18n';

export default {
    name: 'edit-settings',

    components: {
        PageHeader,
    },

    directives: {
        Hover,
    },

    mixins: [i18n],

    data() {
        return {
            isReady: false,
        };
    },

    computed: {
        auth() {
            return this.$store.state.auth;
        },

        config() {
            return this.$store.state.config;
        },

        latestRelease() {
            return {
                tag: this.config.version,
                link: `https://github.com/cnvs/canvas/releases/tag/${this.config.version}`,
            };
        },
    },

    created() {
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        getLocaleDisplayName(locale) {
            return i18n.methods.getDisplayName(locale);
        },

        toggleDigest() {
            this.$store.dispatch('auth/updateDigest', this.auth);
        },

        selectLocale() {
            this.$store.dispatch('config/updateI18n', this.auth.locale);
            this.$store.dispatch('auth/updateLocale', this.auth);
        },

        toggleDarkMode() {
            this.$store.dispatch('auth/updateDarkMode', this.auth);

            if (this.auth.darkMode === true) {
                document.body.setAttribute('data-theme', 'dark');
            } else {
                document.body.removeAttribute('data-theme');
            }
        },
    },
};
</script>
