<template>
    <div v-cloak>
        <vue-frappe
                id="stats"
                :labels="labels"
                :title="trans.stats.cards.views.title"
                type="line"
                :axisOptions="{
                    xIsSeries: true,
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
                    formatTooltipY: d => d + pluralize(trans.stats.chart.view, d),
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
        props: {
            views: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                points: [{
                    values: Object.values(this.views)
                }],
                labels: Object.keys(this.views),
                trans: JSON.parse(Canvas.lang),
            }
        },
    }
</script>

<style>
    #stats > div > svg > g > g.dataset-units.dataset-line.dataset-0 > path.line-graph-path {
        stroke-width: 2px !important;
    }
</style>
