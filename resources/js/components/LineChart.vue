<template>
    <div v-if="isReady">
        <vue-frappe
                id="stats"
                :labels="labels"
                :title="trans.stats.cards.views.title"
                type="line"
                :axisOptions="{
                    xIsSeries: true
                }"
                :lineOptions="{
                    regionFill: 1,
                    hideDots: 1
                }"
                :height="250"
                :colors="['#3490dc']"
                :dataSets="points"
                :tooltipOptions="{
                    formatTooltipX: d => moment(d, 'YYYY-MM-DD').format('dddd, MMMM Do'),
                    formatTooltipY: d => d + plural(trans.stats.chart.view, d),
                }">
        </vue-frappe>
    </div>
</template>

<script>
    import Vue from 'vue'
    import moment from 'moment';
    import Chart from 'vue2-frappe'

    Vue.use(Chart);
    Vue.prototype.moment = moment;

    export default {
        name: 'line-chart',

        props: {
            views: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                labels: [],
                points: [],
                trans: JSON.parse(Canvas.lang),
                isReady: false,
            }
        },

        mounted() {
            this.plotDataPoints(this.views);

            this.isReady = true;
        },

        methods: {
            /**
             * Plot the data and assign labels to the axis.
             *
             * todo: Still need to address <svg> draw issues of NaN values
             * @link https://github.com/frappe/charts/issues/220
             *
             * @param data
             */
            plotDataPoints(data) {
                this.labels = Object.keys(data);
                this.points = [{
                    values: Object.values(data)
                }];
            }
        }
    }
</script>
