<script type="text/ecmascript-6">
    import Vue from 'vue'
    import Chart from 'vue2-frappe'
    import moment from 'moment';

    Vue.use(Chart);
    Vue.prototype.moment = moment;

    export default {
        props: ['views'],

        data() {
            return {
                points: [{
                    values: Object.values(this.views)
                }],

                labels: Object.keys(this.views)
            }
        }
    }
</script>

<template>
    <div>
        <vue-frappe
                id="stats"
                :labels="this.labels"
                title="Views (Last 30 days)"
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
                :dataSets="this.points"
                :tooltipOptions="{
                    formatTooltipX: d => moment(d, 'YYYY-MM-DD').format('dddd, MMMM Do'),
                    formatTooltipY: d => d + ' views',
                }">
        </vue-frappe>
    </div>
</template>