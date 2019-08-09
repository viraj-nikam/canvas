<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <router-link to="/topics/create" class="btn btn-sm btn-outline-primary my-auto ml-auto">
                            {{ trans.buttons.topics.create }}
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
                            <h1 class="mt-2">{{ trans.topics.header }}</h1>

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
                                                   :placeholder="trans.topics.search.input"
                                                   autofocus>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div v-if="isReady">
                            <div v-if="topics.length" class="mt-2">
                                <div class="d-flex border-top py-3 align-items-center" v-for="tag in filteredList">
                                    <div class="mr-auto">
                                        <p class="mb-0 py-1">
                                            <router-link :to="{ name: 'topics-edit', params: {id: tag.id } }" class="font-weight-bold lead">
                                                {{ tag.name }}
                                            </router-link>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted mr-3">{{ tag.posts_count }} {{ trans.topics.posts }}</span>
                                        {{ trans.topics.details.created }} {{ moment(tag.created_at).fromNow() }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a href="#!" class="btn btn-link" @click="limit += 10" v-if="loadMore">{{ trans.buttons.general.load }}
                                        <i class="fa fa-fw fa-angle-down"></i>
                                    </a>
                                </div>

                                <p v-if="!filteredList.length">{{ trans.topics.search.empty }}</p>
                            </div>
                            <p v-else class="mt-2">{{ trans.topics.empty.description }}
                                <router-link to="/topics/create">
                                    {{ trans.topics.empty.action }}
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
        name: 'topics',

        components: {
            ProfileDropdown
        },

        data() {
            return {
                topics: [],
                search: '',
                limit: 10,
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
                    .get('/api/topics')
                    .then((response) => {
                        this.topics = response.data;
                        this.isReady = true;
                    })
                    .catch((error) => {
                        // Add any error debugging...
                    });
            },
        },

        computed: {
            /**
             * Filter topics by their name.
             *
             * @source https://codepen.io/AndrewThian/pen/QdeOVa
             */
            filteredList() {
                let filtered = this.topics.filter(tag => {
                    return tag.name.toLowerCase().includes(this.search.toLowerCase())
                });

                this.loadMore = Object.keys(filtered).length > this.limit;

                return this.limit ? filtered.slice(0, this.limit) : this.topics;
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
</style>
