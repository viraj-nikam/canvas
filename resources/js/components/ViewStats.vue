<script type="text/ecmascript-6">
    import Vue from 'vue'
    import Chart from 'vue2-frappe'

    Vue.use(Chart);

    export default {
        props: ['views'],

        data() {
            return {
                // TODO: TASK - Loop through the views property and grab values
                data: [{
                    name: "Views", chartType: 'line',
                    values: [15, 20, 35, 33, 47, 32, 29, 34, 15, 20, 79, 82, 84, 78, 132, 205]
                }]
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
                :height="300"
                :colors="['#3490dc']"
                :dataSets="this.data">
        </vue-frappe>
    </div>
</template>