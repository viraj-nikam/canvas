<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <router-link to="/posts/create" class="btn btn-sm btn-outline-primary my-auto ml-auto">
                            {{ trans.buttons.posts.create }}
                        </router-link>

                        <profile-dropdown></profile-dropdown>
                    </nav>
                </div>
            </div>
        </div>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <h1 class="mt-2">{{ trans.posts.header }}</h1>

                            <div class="dropdown my-auto">
                                <a href="#" class="nav-link px-0 pb-0 pt-3 text-secondary" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right py-0" id="searchDropdown" aria-labelledby="dropdownMenuButton">
                                    <form class="pl-2 w-100">
                                        <div class="form-group mb-0">
                                            <input v-model="search"
                                                   type="text"
                                                   class="form-control border-0 pl-0"
                                                   id="search"
                                                   :placeholder="trans.posts.search.input"
                                                   autofocus>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div v-if="isReady">
                            <div v-if="posts.length" class="mt-2">
                                <div class="d-flex border-top py-3 align-items-center" v-for="post in filteredList">
                                    <div class="mr-auto py-1">
                                        <p class="mb-1">
                                            <router-link :to="{ name: 'posts-edit', params: {id: post.id } }" class="font-weight-bold lead">
                                                {{ post.title }}
                                            </router-link>
                                        </p>
                                        <p class="mb-1" v-if="post.summary">{{ post.summary }}</p>
                                        <p class="text-muted mb-0">
                                            <span v-if="post.published_at <= moment(new Date()).tz(timezone).format().slice(0, 19).replace('T', ' ')">
                                                {{ trans.posts.details.published }} {{ moment(post.published_at).fromNow() }}
                                            </span>
                                            <span v-else class="text-danger">
                                                {{ trans.posts.details.draft }}
                                            </span>
                                                ― {{ trans.posts.details.updated }} {{ moment(post.updated_at).fromNow() }}
                                        </p>
                                    </div>
                                    <div class="ml-auto d-none d-lg-block">
                                        <router-link :to="{ name: 'posts-edit', params: {id: post.id } }">
                                            <div v-if="post.featured_image"
                                                 id="featuredImage"
                                                 class="mr-2"
                                                 :style="{ backgroundImage: 'url(' + post.featured_image + ')' }">
                                            </div>
                                            <span v-else class="fa-stack fa-2x align-middle">
                                                <i class="fas fa-circle fa-stack-2x text-black-50"></i>
                                                <i class="fas fa-fw fa-stack-1x fa-camera fa-inverse"></i>
                                            </span>
                                        </router-link>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a href="#!"
                                       class="btn btn-link"
                                       @click="limit += 7"
                                       v-if="loadMore">
                                        {{ trans.buttons.general.load }}
                                        <i class="fa fa-fw fa-angle-down"></i>
                                    </a>
                                </div>

                                <p v-if="!filteredList.length">{{ trans.posts.search.empty }}</p>
                            </div>
                            <p v-else class="mt-2">{{ trans.posts.empty.description }}
                                <router-link to="/posts/create">
                                    {{ trans.posts.empty.action }}
                                </router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import ProfileDropdown from '../../components/ProfileDropdown';

    export default {
        name: 'posts',

        components: {
            ProfileDropdown
        },

        data() {
            return {
                posts: [],
                search: '',
                limit: 7,
                loadMore: false,
                isReady: false,
                timezone: Canvas.timezone,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                this.request()
                    .get('/api/posts')
                    .then((response) => {
                        this.posts = response.data;

                        this.isReady = true;
                    })
                    .catch((error) => {
                        // Add any error debugging...
                    });
            },
        },

        computed: {
            /**
             * Filter posts by their title.
             *
             * @source https://codepen.io/AndrewThian/pen/QdeOVa
             */
            filteredList() {
                let filtered = this.posts.filter(post => {
                    return post.title.toLowerCase().includes(this.search.toLowerCase())
                });

                this.loadMore = Object.keys(filtered).length > this.limit;

                return this.limit ? filtered.slice(0, this.limit) : this.posts;
            }
        }
    }
</script>

<style scoped>
    #navbarDropdown {
        margin-top: -8px;
    }

    #searchDropdown {
        min-width: 15rem;
    }

    #featuredImage {
        background-size: cover;
        width: 57px;
        height: 57px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }
</style>
