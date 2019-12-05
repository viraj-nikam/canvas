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
                hideDots: 1,
            }"
            :height="250"
            :colors="['#03a87c']"
            :dataSets="points"
            :tooltipOptions="{
                formatTooltipX: d => moment(d, 'YYYY-MM-DD').format('dddd, MMMM Do'),
                formatTooltipY: d => d + plural(trans.stats.chart.view, d),
            }"
        />
    </div>
</template>

<script>
    import Vue from 'vue'
    import moment from 'moment'
    import VueFrappe from 'vue-frappe'

    Vue.prototype.moment = moment

    export default {
        name: 'line-chart',

        components: {
            VueFrappe,
        },

        props: {
            views: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                labels: Object.keys(this.views),
                points: [{
                    values: Object.values(this.views),
                }],
                trans: JSON.parse(Canvas.lang),
                isReady: false,
            }
        }
    }
</script>
