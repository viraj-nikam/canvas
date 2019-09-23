<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <router-link :to="{ name: 'topics-create' }" class="btn btn-sm btn-outline-primary my-auto ml-auto">
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
                            <h1 class="mt-2">
                                {{ trans.topics.header }}
                            </h1>

                            <div class="dropdown my-auto">
                                <a id="navbarDropdown" href="#" class="nav-link px-0 pb-0 pt-3 text-secondary" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search"></i>
                                </a>
                                <div id="searchDropdown" class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="dropdownMenuButton">
                                    <form class="pl-2 w-100">
                                        <div class="form-group mb-0">
                                            <input id="search" v-model="search" type="text" class="form-control border-0 pl-0" :placeholder="trans.topics.search.input" autofocus/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div v-if="isReady">
                            <div v-if="topics.length" class="mt-2">
                                <div v-for="topic in filteredList" class="d-flex border-top py-3 align-items-center">
                                    <div class="mr-auto">
                                        <p class="mb-0 py-1">
                                            <router-link :to="{name: 'topics-edit', params: { id: topic.id }}" class="font-weight-bold lead">
                                                {{ topic.name }}
                                            </router-link>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted mr-3">{{ topic.posts_count }} {{ trans.topics.posts }}</span>
                                        {{ trans.topics.details.created }}
                                        {{ moment(topic.created_at).fromNow() }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a v-if="loadMore" href="#!" class="btn btn-link" @click="limit += 10">
                                        {{ trans.buttons.general.load }}
                                        <i class="fa fa-fw fa-angle-down"></i>
                                    </a>
                                </div>

                                <p v-if="!filteredList.length">
                                    {{ trans.topics.search.empty }}
                                </p>
                            </div>
                            <p v-else class="mt-2">
                                {{ trans.topics.empty.description }}
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
    import ProfileDropdown from "../../components/ProfileDropdown";

    export default {
        name: "Topics",

        components: {
            ProfileDropdown
        },

        data() {
            return {
                topics: [],
                search: "",
                limit: 10,
                loadMore: false,
                isReady: false,
                timezone: Canvas.timezone,
                trans: JSON.parse(Canvas.lang)
            };
        },

        computed: {
            /**
             * Filter topics by their name.
             *
             * @source https://codepen.io/AndrewThian/pen/QdeOVa
             */
            filteredList() {
                let filtered = this.topics.filter(tag => {
                    return tag.name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                });

                this.loadMore = Object.keys(filtered).length > this.limit;

                return this.limit ? filtered.slice(0, this.limit) : this.topics;
            }
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                this.request()
                    .get("/api/topics")
                    .then(response => {
                        this.topics = response.data;
                        this.isReady = true;
                    })
                    .catch(error => {
                        // Add any error debugging...
                    });
            }
        }
    };
</script>

<style scoped>
    #navbarDropdown {
        margin-top: -8px;
    }

    #searchDropdown {
        min-width: 15rem;
    }
</style>
