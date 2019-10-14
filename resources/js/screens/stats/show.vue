<template>
    <div>
        <page-header>
            <template slot="right">
                <router-link to="/stats" class="btn btn-sm btn-outline-success font-weight-bold my-auto ml-auto">
                    {{ trans.buttons.stats.index }}
                </router-link>
            </template>
        </page-header>

        <main class="py-3">
            <div class="container" v-if="isReady">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h5 class="text-muted small text-uppercase font-weight-bold mt-2">
                            {{ trans.stats.details.published }}
                            {{ moment(post.published_at).format("MMM D, YYYY") }}
                        </h5>
                        <h1 class="mb-4">{{ post.title }}</h1>

                        <line-chart :views="JSON.parse(views)"></line-chart>
                    </div>

                    <div class="col-md-5 mt-4">
                        <h5 class="text-muted small text-uppercase font-weight-bold border-bottom pb-2">
                            {{ trans.stats.details.views }}
                        </h5>

                        <div v-if="traffic">
                            <div v-for="(views, host, index) in traffic">
                                <div class="d-flex py-2 align-items-center">
                                    <div class="mr-auto">
                                        <div v-if="host === trans.stats.details.referer.other">
                                            <p class="mb-0 py-1">
                                                <img :src="`https://favicons.githubusercontent.com/${host}`" :alt="host" class="mr-1"/>
                                                <a href="#" v-tooltip="{ placement: 'right' }" class="text-dark text-decoration-none" :title="trans.stats.details.referer.unknown">
                                                    {{ host }}
                                                    <i class="fas fa-fw fa-question-circle text-muted"></i>
                                                </a>
                                            </p>
                                        </div>
                                        <div v-else>
                                            <p class="mb-0 py-1">
                                                <img :src="`https://favicons.githubusercontent.com/${host}`" :alt="host" class="mr-1"/>
                                                <a :href="'http://' + host" class="text-dark text-decoration-none" target="_blank">{{ host }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted">{{ suffixedNumber(views) }} {{ trans.stats.views }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p v-else class="py-2 font-italic">
                            {{ trans.stats.details.empty }}
                        </p>
                    </div>

                    <div class="col-md-5 mt-4">
                        <h5 class="text-muted small text-uppercase font-weight-bold border-bottom pb-2">
                            {{ trans.stats.details.reading.header }}
                        </h5>

                        <div v-if="popular_reading_times">
                            <div v-for="(percentage, time, index) in popular_reading_times">
                                <div class="d-flex py-2 align-items-center">
                                    <div class="mr-auto">
                                        <p class="mb-0 py-1">
                                            {{ time }}
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted">{{ percentage + "%" }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p v-else class="py-2 font-italic">
                            {{ trans.stats.details.empty }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import Tooltip from "../../directives/tooltip";
    import LineChart from "../../components/LineChart";
    import PageHeader from "../../components/PageHeader";

    export default {
        name: "stats-show",

        components: {
            LineChart,
            PageHeader
        },

        directives: {
            Tooltip
        },

        data() {
            return {
                id: this.$route.params.id,
                post: null,
                views: null,
                popular_reading_times: null,
                traffic: null,
                isReady: false,
                trans: JSON.parse(Canvas.lang)
            };
        },

        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.request()
                    .get("/api/stats/" + vm.id)
                    .then(response => {
                        vm.post = response.data.post;
                        vm.views = response.data.views;
                        vm.traffic = Array.isArray(response.data.traffic) ? null : response.data.traffic;
                        vm.popular_reading_times = Array.isArray(response.data.popular_reading_times) ? null : response.data.popular_reading_times;

                        vm.isReady = true;
                    })
                    .catch(error => {
                        vm.$router.push({name: "stats"});
                    });
            });
        }
    };
</script>

<style scoped>
    img {
        width: 15px;
        height: 15px;
    }
</style>
