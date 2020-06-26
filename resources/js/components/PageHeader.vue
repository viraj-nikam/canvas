<template>
    <div class="shadow">
        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
            <nav class="navbar d-flex px-0 py-0">
                <router-link to="/" class="navbar-brand pt-0 hover">
                    canvas
                </router-link>

                <!--                <div class="mx-2 d-flex flex-grow-1 justify-content-center">-->
                <!--                    <div class="input-group">-->
                <!--                        <div class="input-group-prepend mr-0 border-0">-->
                <!--                            <div class="input-group-text pr-0 border-0">-->
                <!--                                <svg-->
                <!--                                    xmlns="http://www.w3.org/2000/svg"-->
                <!--                                    viewBox="0 0 24 24"-->
                <!--                                    width="20"-->
                <!--                                    class="icon-search"-->
                <!--                                >-->
                <!--                                    <circle cx="10" cy="10" r="7" style="fill: none;" />-->
                <!--                                    <path-->
                <!--                                        class="fill-muted"-->
                <!--                                        d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"-->
                <!--                                    />-->
                <!--                                </svg>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <input class="form-control border-0" type="text" placeholder="Search..." />-->
                <!--                    </div>-->
                <!--                </div>-->

                <a href="#" class="hover-light ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" class="icon-search pr-1">
                        <circle cx="10" cy="10" r="7" style="fill: none;" />
                        <path
                            class="fill-light-gray"
                            d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"
                        />
                    </svg>
                </a>

                <slot name="menu" />

                <div class="dropdown ml-3" v-cloak>
                    <a
                        href="#"
                        id="navbarDropdown"
                        class="nav-link px-0 text-secondary"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <img
                            :src="avatar"
                            :alt="name"
                            class="rounded-circle my-0 shadow-inset hover-light"
                            style="width: 33px;"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <h6 class="dropdown-header">
                            <strong>{{ name }}</strong>
                            <br />
                            {{ email }}
                        </h6>

                        <div class="dropdown-divider"></div>

                        <router-link :to="{ name: 'edit-profile' }" class="dropdown-item">
                            {{ i18n.your_profile }}
                        </router-link>
                        <router-link :to="{ name: 'posts' }" class="dropdown-item">
                            <span>{{ i18n.posts_simple }}</span>
                        </router-link>
                        <router-link :to="{ name: 'tags' }" class="dropdown-item">
                            <span>{{ i18n.tags }}</span>
                        </router-link>
                        <router-link :to="{ name: 'topics' }" class="dropdown-item">
                            <span>{{ i18n.topics }}</span>
                        </router-link>
                        <router-link :to="{ name: 'all-stats' }" class="dropdown-item">
                            <span>{{ i18n.stats }}</span>
                        </router-link>

                        <div class="dropdown-divider"></div>

                        <router-link :to="{ name: 'edit-settings' }" class="dropdown-item">
                            <span>{{ i18n.settings }}</span>
                        </router-link>
                        <a href="" class="dropdown-item" @click.prevent="logout">
                            {{ i18n.sign_out }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import store from '../store';
import i18n from '../mixins/i18n';

export default {
    name: 'page-header',

    mixins: [i18n],

    computed: {
        avatar() {
            return store.state.user.avatar;
        },

        name() {
            return store.state.user.name;
        },
        email() {
            return store.state.user.email;
        },
    },

    methods: {
        logout() {
            let instance = axios.create();

            instance.defaults.baseURL = '/';

            instance.post('/logout').then(() => {
                window.location.href = '/login';
            });
        },
    },
};
</script>

<style scoped lang="scss">
@import '../../sass/utilities/variables';

.navbar-brand {
    font-size: 2.5rem;
    font-family: 'Caveat', serif;
}
</style>
