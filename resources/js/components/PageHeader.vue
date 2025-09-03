<template>
    <div class="border-bottom">
        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
            <nav class="navbar d-flex px-0 py-1">
                <router-link :to="{ name: 'home' }" class="navbar-brand hover font-weight-bolder font-serif mr-6">
                    Canvas
                </router-link>

                <slot name="status" />

                <div class="ml-auto d-flex">
                    <!-- Desktop navigation (hidden on mobile) -->
                    <div class="d-none d-md-flex align-items-center">
                        <router-link :to="{ name: 'notes' }" class="px-3">
                            {{ trans.notes }}
                        </router-link>
                        <router-link :to="{ name: 'posts' }" class="px-3">
                            {{ trans.posts }}
                        </router-link>
                        <router-link v-if="isAdmin" :to="{ name: 'tags' }" class="px-3">
                            {{ trans.tags }}
                        </router-link>
                        <router-link v-if="isAdmin" :to="{ name: 'topics' }" class="px-3">
                            {{ trans.topics }}
                        </router-link>
                    </div>
                    <a href="#" class="px-3" @click="showSearchModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" class="icon-search pr-1">
                            <circle cx="10" cy="10" r="7" style="fill: none" />
                            <path
                                class="fill-light-gray"
                                d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"
                            />
                        </svg>
                    </a>
                </div>

                <slot name="options" />

                <div v-cloak class="dropdown ml-3">
                    <a
                        id="navbarDropdown"
                        href="#"
                        class="nav-link px-0 text-secondary"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <img
                            :src="settings.user.avatar || settings.user.default_avatar"
                            :alt="settings.user.name"
                            class="rounded-circle my-0 shadow-inner"
                            style="width: 33px"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <h6 class="dropdown-header">
                            <strong>{{ settings.user.name }}</strong>
                            <br />
                            {{ settings.user.email }}
                        </h6>

                        <div class="dropdown-divider" />

                        <router-link
                            :to="{ name: 'edit-user', params: { id: settings.user.id } }"
                            class="dropdown-item"
                        >
                            {{ trans.your_profile }}
                        </router-link>
                        <router-link v-if="isAdmin" :to="{ name: 'users' }" class="dropdown-item">
                            <span>{{ trans.users }}</span>
                        </router-link>
                        <router-link :to="{ name: 'stats' }" class="dropdown-item">
                            <span>{{ trans.stats }}</span>
                        </router-link>

                        <div class="dropdown-divider" />

                        <router-link :to="{ name: 'edit-settings' }" class="dropdown-item">
                            <span>{{ trans.settings }}</span>
                        </router-link>
                        <a href="" class="dropdown-item" @click.prevent="logout">
                            {{ trans.sign_out }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <search-modal ref="searchModal" />
        <!-- Mobile bottom navigation  -->
        <div
            class="d-md-none navbar fixed-bottom border-top"
            :class="isDark ? '' : 'bg-white'"
            :style="isDark ? 'background-color: rgb(38, 50, 56);' : ''"
        >
            <div class="d-flex justify-content-around w-100">
                <!-- Notes -->
                <router-link :to="{ name: 'notes' }" class="text-center small">
                    <div class="d-flex flex-column align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            :stroke="isDark ? '#ECECEC' : '#6c757d'"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
                            <line x1="8" y1="9" x2="16" y2="9" />
                            <line x1="8" y1="13" x2="16" y2="13" />
                            <line x1="8" y1="17" x2="14" y2="17" />
                        </svg>
                        <small>{{ trans.notes }}</small>
                    </div>
                </router-link>

                <!-- Posts -->
                <router-link :to="{ name: 'posts' }" class="text-center small">
                    <div class="d-flex flex-column align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            :stroke="isDark ? '#ECECEC' : '#6c757d'"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="3" y="4" width="18" height="16" rx="2" ry="2" />
                            <rect x="6" y="8" width="6" height="4" />
                            <line x1="13" y1="13" x2="19" y2="13" />
                            <line x1="13" y1="17" x2="19" y2="17" />
                        </svg>
                        <small>{{ trans.posts }}</small>
                    </div>
                </router-link>

                <!-- Tags -->
                <router-link v-if="isAdmin" :to="{ name: 'tags' }" class="text-center small">
                    <div class="d-flex flex-column align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            :stroke="isDark ? '#ECECEC' : '#6c757d'"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0l-6.59-6.59A2 2 0 0 1 3 12.59V7a2 2 0 0 1 2-2h5.59a2 2 0 0 1 1.41.59l8.59 8.59z"
                            />
                            <circle cx="7.5" cy="7.5" r="1.5" />
                        </svg>
                        <small>{{ trans.tags }}</small>
                    </div>
                </router-link>

                <!-- Topics -->
                <router-link v-if="isAdmin" :to="{ name: 'topics' }" class="text-center small">
                    <div class="d-flex flex-column align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            :stroke="isDark ? '#ECECEC' : '#6c757d'"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M4 6h8l2 2h6a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z" />
                        </svg>
                        <small>{{ trans.topics }}</small>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import $ from 'jquery';
import SearchModal from './modals/SearchModal';
import { store } from '../store';

export default {
    name: 'page-header',

    components: {
        SearchModal,
    },

    computed: {
        ...mapState(['settings']),
        ...mapGetters({
            isAdmin: 'settings/isAdmin',
            trans: 'settings/trans',
        }),
        isDark() {
            try {
                return Boolean(this.settings.user && this.settings.user.dark_mode);
            } catch (e) {
                return false;
            }
        },
    },

    methods: {
        logout() {
            if (store.state.settings.path === '/') {
                window.location.href = `/logout`;
            } else {
                window.location.href = `${store.state.settings.path}/logout`;
            }
        },

        showSearchModal() {
            $(this.$refs.searchModal.$el).modal('show');
        },
    },
};
</script>
