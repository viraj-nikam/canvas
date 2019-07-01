<template>
    <div class="dropdown">
        <a href="#" id="navbarDropdown" class="nav-link px-0 text-secondary" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img v-bind:src="gravatar"
                 :alt="user.name"
                 class="rounded-circle my-0"
                 style="width: 31px"
            >
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <h6 class="dropdown-header">
                <strong>{{ user.name }}</strong><br>{{ user.email }}
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
            <router-link to="/logout" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                {{ trans.nav.user.logout }}
            </router-link>
            <form id="logout-form" action="/logout" method="POST" class="d-none">
                <input type="hidden" name="_token" v-model="token">
            </form>
        </div>
    </div>
</template>

<script>
    import md5 from 'md5';

    export default {
        name: "profile-dropdown",

        props: {
            authenticatedUser: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                user: this.authenticatedUser,
                gravatar: this.generateGravatarUrl(this.authenticatedUser.email, 200),
                token: document.head.querySelector('meta[name="csrf-token"]').content,
                trans: JSON.parse(Canvas.lang),
            }
        },

        methods: {
            /**
             * Generate an MD5 hash from a given email to retrieve a Gravatar.
             *
             * @param email
             * @param size
             * @returns {string}
             */
            generateGravatarUrl(email, size) {
                return 'https://secure.gravatar.com/avatar/' + md5(email.toLowerCase().trim()) + '?s=' + size;
            },
        }
    }
</script>

<style scoped>

</style>
