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
                    <p v-if="isReady && posts.length">{{ trans.stats.subtext }}</p>
                </div>

                <div v-if="isReady" v-cloak>
                    <div v-if="posts.length">
                        <div class="card-deck mt-4">
                            <div class="card shadow bg-transparent overflow-hidden">
                                <div class="card-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" viewBox="0 0 24 24" class="icon-view-visible position-absolute" style="opacity: .1;right: 0;top:0"><path class="primary" d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zM11.9 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/><circle cx="12" cy="12" r="3" class="secondary"/></svg>
                                    <h5 class="card-title text-muted small text-uppercase font-weight-bold">
                                        {{ trans.stats.cards.views.title }}
                                    </h5>
                                    <p class="card-text display-4">
                                        {{ suffixedNumber(viewCount) }}
                                    </p>
                                </div>
                            </div>
                            <div class="card shadow bg-transparent overflow-hidden">
                                <div class="card-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" viewBox="0 0 24 24" class="icon-user-group position-absolute" style="opacity: .1;right: 0;top:0"><path class="primary" d="M12 13a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v3a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1 1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-3a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3zM7 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm10 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/><path class="secondary" d="M12 13a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm-3 1h6a3 3 0 0 1 3 3v3a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-3a3 3 0 0 1 3-3z"/></svg>
                                    <h5 class="card-title text-muted small text-uppercase font-weight-bold">
                                        {{ trans.stats.cards.posts.title }}
                                    </h5>
                                    <p class="card-text display-4">
                                        {{ publishedCount + draftCount }}
                                    </p>
                                </div>
                            </div>
                            <div class="card shadow bg-transparent overflow-hidden">
                                <div class="card-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" viewBox="0 0 24 24" class="icon-edit position-absolute" style="opacity: .1;right: 0;top:0"><path class="primary" d="M4 14a1 1 0 0 1 .3-.7l11-11a1 1 0 0 1 1.4 0l3 3a1 1 0 0 1 0 1.4l-11 11a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-3z"/><rect width="20" height="2" x="2" y="20" class="secondary" rx="1"/></svg>
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
                        <p class="mt-4">{{ trans.stats.empty }}</p>
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
            this.fetchPosts()
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
                        if (!_.isEmpty(response.data) && !_.isEmpty(response.data.posts.data)) {
                            this.page += 1;
                            this.posts.push(...response.data.posts.data)

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
