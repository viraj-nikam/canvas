<template>
    <div>
        <page-header>
            <template slot="action">
                <router-link :to="{ name: 'posts-create' }" class="btn btn-sm btn-outline-success font-weight-bold my-auto">
                    {{ trans.buttons.posts.create }}
                </router-link>
            </template>
        </page-header>

        <main class="py-4">
            <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
                <div class="my-3">
                    <h1>{{ trans.stats.header }}</h1>
                    <p>{{ trans.stats.subtext }}</p>
                </div>

                <div v-if="isReady" v-cloak>
                    <div v-if="posts.length">
                        <div class="card-deck mt-4">
                            <div class="card shadow bg-transparent">
                                <div class="card-body">
                                    <h5 class="card-title text-muted small text-uppercase font-weight-bold">
                                        {{ trans.stats.cards.views.title }}
                                    </h5>
                                    <p class="card-text display-4">
                                        {{ suffixedNumber(viewCount) }}
                                    </p>
                                </div>
                            </div>
                            <div class="card shadow bg-transparent">
                                <div class="card-body">
                                    <h5 class="card-title text-muted small text-uppercase font-weight-bold">
                                        {{ trans.stats.cards.posts.title }}
                                    </h5>
                                    <p class="card-text display-4">
                                        {{ publishedCount + draftCount }}
                                    </p>
                                </div>
                            </div>
                            <div class="card shadow bg-transparent">
                                <div class="card-body">
                                    <h5 class="card-title text-muted small text-uppercase font-weight-bold">
                                        {{ trans.stats.cards.publishing.title }}
                                    </h5>
                                    <ul>
                                        <li>
                                            {{ publishedCount }}
                                            {{ trans.stats.cards.publishing.details.published }}
                                        </li>
                                        <li>
                                            {{ draftCount }}
                                            {{ trans.stats.cards.publishing.details.drafts }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <line-chart :views="JSON.parse(viewTrend)" class="mt-5"/>

                        <div class="mt-5">
                            <div v-for="(post, $index) in posts" :key="$index" class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto">
                                    <p class="mb-1 mt-2">
                                        <router-link :to="{name: 'stats-show', params: { id: post.id }}" class="font-weight-bold text-lg lead text-decoration-none">
                                            {{ post.title }}
                                        </router-link>
                                    </p>
                                    <p class="text-muted mb-2">
                                        {{ post.read_time }} ―
                                        <router-link :to="{name: 'posts-edit', params: { id: post.id }}" class="text-decoration-none text-muted">
                                            {{ trans.buttons.posts.edit }}
                                        </router-link>
                                        ―
                                        <router-link :to="{name: 'stats-show', params: { id: post.id }}" class="text-decoration-none text-muted">
                                            {{ trans.buttons.stats.show }}
                                        </router-link>
                                    </p>
                                </div>
                                <div class="ml-auto d-none d-lg-block">
                                            <span class="text-muted mr-3">
                                                {{ suffixedNumber(post.views_count) }}
                                                {{ trans.stats.views }}
                                            </span>
                                    {{ trans.stats.details.created }}
                                    {{ moment(post.created_at).fromNow() }}
                                </div>
                            </div>
                        </div>

                        <infinite-loading @infinite="fetchPosts" spinner="spiral">
                            <span slot="no-more"></span>
                            <div slot="no-results"></div>
                        </infinite-loading>
                    </div>

                    <div v-else>
                        <p class="mt-3">{{ trans.stats.empty }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import NProgress from 'nprogress'
    import InfiniteLoading from 'vue-infinite-loading'
    import LineChart from '../../components/LineChart'
    import PageHeader from '../../components/PageHeader'

    export default {
        name: 'stats-index',

        components: {
            LineChart,
            InfiniteLoading,
            PageHeader,
        },

        data() {
            return {
                page: 1,
                posts: [],
                publishedCount: 0,
                draftCount: 0,
                viewCount: 0,
                viewTrend: {},
                isReady: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
              this.fetchStats()
        },

        methods: {
            fetchStats() {
                this.request()
                    .get('/api/stats')
                    .then(response => {
                        this.viewCount = response.data.view_count
                        this.viewTrend = response.data.view_trend
                        this.publishedCount = response.data.published_count
                        this.draftCount = response.data.draft_count

                        this.isReady = true;
                        NProgress.done()
                    })
                    .catch(error => {
                        // Add any error debugging...

                        NProgress.done()
                    })
            },

            fetchPosts($state) {
                this.request()
                    .get('/api/posts', {
                        params: {
                            page: this.page
                        },
                    })
                    .then(response => {
                        if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
                            this.page += 1;
                            this.posts.push(...response.data.data)

                            $state.loaded();
                        } else {
                            $state.complete();
                        }

                        NProgress.done()
                    })
                    .catch(error => {
                        // Add any error debugging...

                        NProgress.done()
                    })
            },
        }
    }
</script>
