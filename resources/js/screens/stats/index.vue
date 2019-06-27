<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-2">{{ this.trans.stats.header }}</h1>

                <div v-if="this.isReady && this.posts.all.length">
                    <p class="mt-3 mb-4">{{ this.trans.stats.subtext }}</p>

                    <div class="card-deck mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.trans.stats.cards.views.title }}</h5>
                                <p class="card-text display-4">{{ this.views.count }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.trans.stats.cards.posts.title }}</h5>
                                <p class="card-text display-4">{{ this.posts.drafts_count + this.posts.published_count }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.trans.stats.cards.publishing.title }}</h5>
                                <ul>
                                    <li>{{ this.posts.published_count }} {{ this.trans.stats.cards.publishing.details.published }}</li>
                                    <li>{{ this.posts.drafts_count }} {{ this.trans.stats.cards.publishing.details.drafts }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <line-chart :views="JSON.parse(this.views.trend)"></line-chart>

                    <div class="mt-4">
                        <div class="d-flex border-top py-3 align-items-center" v-for="post in filteredList">
                            <p class="font-weight-bold">{{ post.title }}</p>
                            <div class="mr-auto">
                                <p class="mb-1 mt-2">
                                    <router-link :to="{ name: 'stats-show', params: {id: post.id } }" class="font-weight-bold lead">
                                        <span>{{ post.title }}</span>
                                    </router-link>
                                </p>
                                <p class="text-muted mb-2">
                                    {{ post.read_time }}
                                    ―
                                    <router-link :to="{ name: 'posts-edit', params: {id: post.id } }" class="font-weight-bold lead">
                                        <span>{{ this.trans.buttons.posts.edit }}</span>
                                    </router-link>
                                    ―
                                    <router-link :to="{ name: 'stats-show', params: {id: post.id } }" class="font-weight-bold lead">
                                        <span>{{ this.trans.buttons.stats.show }}</span>
                                    </router-link>
                                </p>
                            </div>
                            <div class="ml-auto d-none d-lg-block">
                                <span class="text-muted mr-3">{{ v.trans.stats.views }}</span>
                                {{ this.trans.stats.details.created }} {{ moment(post.created_at).fromNow() }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="#!" class="btn btn-link" @click="this.limit += 7" v-if="loadMore">{{ this.trans.buttons.general.load }}
                                <i class="fa fa-fw fa-angle-down"></i></a>
                        </div>
                    </div>
                </div>
                <p v-else class="mt-4">{{ this.trans.stats.empty }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import PostList from '../../components/PostList';
    import LineChart from '../../components/LineChart';

    export default {
        name: 'stats',

        components: {
            LineChart,
            PostList
        },

        data() {
            return {
                endpoint: '/api/stats',
                trans: JSON.parse(Canvas.lang),
                posts: [],
                views: [],
                isReady: false,
                loadMore: false,
                limit: 7,
            }
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                this.request().get(this.endpoint
                ).then(response => {
                    this.posts = response.data.posts;
                    this.views = response.data.views;

                    this.isReady = true;
                });
            },
        },

        computed: {
            /**
             * Return all published posts based on a set limit.
             *
             * @source https://codepen.io/AndrewThian/pen/QdeOVa
             */
            filteredList() {
                let filtered = this.posts.all;

                this.loadMore = Object.keys(filtered).length > this.limit;

                return this.limit ? filtered.slice(0, this.limit) : this.posts.all;
            }
        }
    }
</script>

<style scoped>

</style>
