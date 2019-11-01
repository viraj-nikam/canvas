<template>
    <div class="container d-flex justify-content-center px-0">
        <div class="col-md-10 px-0">
            <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-3">
                <router-link to="/" class="navbar-brand font-weight-bold py-0">
                    <span class="font-serif">Canvas</span>
                </router-link>

                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <slot name="status"></slot>
                    </li>
                </ul>

                <div class="my-auto ml-auto">
                    <slot name="action"></slot>
                </div>

                <slot name="menu"></slot>

                <div class="dropdown ml-3" v-cloak>
                    <a href="#" id="navbarDropdown" class="nav-link px-0 text-secondary" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img :src="gravatar()" :alt="user.name" class="rounded-circle my-0 shadow-inner" style="width: 31px"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <h6 class="dropdown-header">
                            <strong>{{ user.name }}</strong>
                            <br/>
                            {{ user.email }}
                        </h6>
                        <div class="dropdown-divider"></div>

                        <router-link to="/posts" class="dropdown-item">
                            <span>{{ trans.nav.user.posts }}</span>
                        </router-link>
                        <router-link to="/tags" class="dropdown-item">
                            <span>{{ trans.nav.user.tags }}</span>
                        </router-link>
                        <router-link to="/topics" class="dropdown-item">
                            <span>{{ trans.nav.user.topics }}</span>
                        </router-link>
                        <router-link to="/stats" class="dropdown-item">
                            <span>{{ trans.nav.user.stats }}</span>
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item" @click.prevent="logout">
                            {{ trans.nav.user.logout }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    import md5 from "md5";
    import axios from "axios";

    export default {
        name: "page-header",

        data() {
            return {
                user: Canvas.user,
                token: document.head.querySelector('meta[name="csrf-token"]').content,
                trans: JSON.parse(Canvas.lang)
            };
        },

        methods: {
            /**
             * Generate an MD5 hash from a given email to retrieve a Gravatar.
             *
             * @returns {string}
             */
            gravatar() {
                let hash = md5(this.user.email.toLowerCase().trim());

                return "https://secure.gravatar.com/avatar/" + hash + "?s=200";
            },

            /**
             * Log the user out of the application.
             *
             * @returns void
             */
            logout() {
                axios
                    .post("/logout", {
                        _token: this.token
                    })
                    .then(response => {
                        window.location.href = "/login";
                    });
            }
        }
    };
</script>

<style scoped>
    a.dropdown-item:active {
        background-color: #f8f9fa;
        color: #16181b;
    }
</style>
