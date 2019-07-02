<template>
    <div class="dropdown" v-cloak>
        <a href="#" id="navbarDropdown" class="nav-link px-0 text-secondary" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img :src="gravatar()"
                 :alt="user.name"
                 class="rounded-circle my-0">
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

        data() {
            return {
                user: Canvas.user,
                token: document.head.querySelector('meta[name="csrf-token"]').content,
                trans: JSON.parse(Canvas.lang),
            }
        },

        methods: {
            /**
             * Generate an MD5 hash from a given email to retrieve a Gravatar.
             *
             * @returns {string}
             */
            gravatar() {
                let hash = md5(this.user.email.toLowerCase().trim());

                return 'https://secure.gravatar.com/avatar/' + hash + '?s=200';
            },
        }
    }
</script>

<style scoped>
    img {
        width: 31px;
    }
</style>
