<script type="text/ecmascript-6">
    import Vue from 'vue'
    import Chart from 'vue2-frappe'

    Vue.use(Chart);

    export default {
        props: ['views'],

        data() {
            return {
                points: [

                    // todo: [task] loop through the views property and grab values

                    {values: [15, 20, 35, 33, 47, 32, 29, 34, 15, 20, 365, 33, 84, 32, 29, 35]}
                ]
            }
        }
    }
</script>

<template>
    <div>
        <vue-frappe
                id="stats"
                :labels="[
                    '12/01', '12/02', '12/03', '12/04',
                    '12/05', '12/06', '12/07', '12/08',
                    '12/09', '12/10', '12/11', '12/12',
                    '12/13', '12/14', '12/15', '12/16'
                ]"
                title="Views (Last 30 days)"
                type="line"
                :height="250"
                :colors="['#3490dc']"
                :dataSets="this.points"
                :tooltipOptions="{
                    formatTooltipX: d => (d + '').toUpperCase(),
                    formatTooltipY: d => d + ' views',
                }"
                >
        </vue-frappe>
    </div>
</template>