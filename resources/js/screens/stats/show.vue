<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <router-link to="/stats" class="btn btn-sm btn-outline-primary my-auto ml-auto">
                            {{ trans.buttons.stats.index }}
                        </router-link>

                        <profile-dropdown></profile-dropdown>
                    </nav>
                </div>
            </div>
        </div>

        <main class="py-4">
            <div class="container" v-if="isReady">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h5 class="text-muted small text-uppercase font-weight-bold mt-2">
                            {{ trans.stats.details.published }} {{ moment(post.published_at).format('MMM D, YYYY') }}
                        </h5>
                        <h1 class="mb-4">{{ post.title }}</h1>

                        <line-chart :views="JSON.parse(views)"></line-chart>
                    </div>

                    <div class="col-md-5 mt-4">
                        <h5 class="text-muted small text-uppercase font-weight-bold">
                            {{ trans.stats.details.views }}
                        </h5>

                        <div v-if="popular_reading_times">
                            <div v-for="(views, host, index) in traffic">
                                <div class="d-flex py-2 align-items-center" :class="{ 'border-top': index === 0 }">
                                    <div class="mr-auto">
                                        <div v-if="host === trans.stats.details.referer.other">
                                            <p class="mb-0 py-1">
                                                <img :src="`https://favicons.githubusercontent.com/${host}`"
                                                     :alt="host"
                                                     style="width: 15px; height: 15px;"
                                                     class="mr-1">
                                                <b-link v-b-tooltip.hover.right
                                                        :title="trans.stats.details.referer.unknown"
                                                        href="#">
                                                    {{ host }} <i class="far fa-fw fa-question-circle text-muted"></i>
                                                </b-link>
                                            </p>
                                        </div>
                                        <div v-else>
                                            <p class="mb-0 py-1">
                                                <img :src="`https://favicons.githubusercontent.com/${host}`"
                                                     :alt="host"
                                                     style="width: 15px; height: 15px;"
                                                     class="mr-1">
                                                <a :href="'http://' + host"
                                                   target="_blank">{{ host }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted">{{ suffixedNumber(views) }} {{ trans.stats.views }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="py-4 border-top" v-else>
                            <em>{{ trans.stats.details.empty }}</em>
                        </p>
                    </div>

                    <div class="col-md-5 mt-4">
                        <h5 class="text-muted small text-uppercase font-weight-bold">
                            {{ trans.stats.details.reading.header }}
                        </h5>

                        <div v-if="popular_reading_times">
                            <div v-for="(percentage, time, index) in popular_reading_times">
                                <div class="d-flex py-2 align-items-center" :class="{ 'border-top': index === 0 }">
                                    <div class="mr-auto">
                                        <p class="mb-0 py-1">
                                            {{ time }}
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted">{{ percentage + '%' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="py-4 border-top" v-else>
                            <em>{{ trans.stats.details.empty }}</em>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import Vue from 'vue'
    import BootstrapVue from 'bootstrap-vue';
    import LineChart from '../../components/LineChart';
    import ProfileDropdown from '../../components/ProfileDropdown';

    Vue.use(BootstrapVue);

    export default {
        name: 'stats-show',

        components: {
            LineChart,
            ProfileDropdown
        },

        data() {
            return {
                id: this.$route.params.id,
                post: [],
                views: {},
                popular_reading_times: [],
                traffic: [],
                isReady: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                try {
                    this.request().get('/api/stats/' + this.id).then((response) => {
                        this.popular_reading_times = response.data.popular_reading_times;
                        this.post = response.data.post;
                        this.traffic = response.data.traffic;
                        this.views = response.data.views;

                        this.isReady = true;
                    }).catch((err) => {
                        console.error(err);
                    });
                } catch (error) {
                    console.error(error);
                }
            },
        }
    }
</script>
