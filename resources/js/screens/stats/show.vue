<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h5 class="text-muted small text-uppercase font-weight-bold mt-2">

<!--                    {{ trans.stats.details.published }} {{ \Carbon\Carbon::parse($data['post']->published_at)->format('F d, Y') }}-->
                    {{ trans.stats.details.published }} {{ post.published_at }}
                </h5>
                <h1 class="mb-4">{{ post.title }}</h1>

                <div v-if="isReady">
                    <line-chart :views="JSON.parse(views)"></line-chart>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from '../../components/LineChart';

    export default {
        name: 'stats-show',

        components: {
            LineChart,
        },

        data() {
            return {
                endpoint: '/api/stats/' + this.$route.params.id,
                trans: JSON.parse(Canvas.lang),
                popular_reading_times: [],
                post: [],
                traffic: [],
                views: {},
                isReady: false,
            }
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                this.request().get(this.endpoint
                ).then(response => {
                    this.popular_reading_times = response.data.popular_reading_times;
                    this.post = response.data.post;
                    this.traffic = response.data.traffic;
                    this.views = response.data.views;

                    this.isReady = true;
                });
            },
        }
    }
</script>
