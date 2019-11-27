<template>
    <div v-if="isReady">
        <la-cartesian autoresize :bound="[0]" :height="250" :data="values">
            <la-area
                fill-color="#A6DDCD"
                prop="views"
                color="#03a87c"
                :width="5"
                curve
            ></la-area>
            <la-x-axis
                :interval="5"
                :format="formatXAxis"
                prop="date"
            ></la-x-axis>
            <la-y-axis
                :format="formatYAxis"
                :gridline="true"
                :gridline-interval="5"
                :interval="5"
                dashed
            ></la-y-axis>
            <la-tooltip></la-tooltip>
        </la-cartesian>
    </div>
</template>

<script>
import Vue from 'vue'
import { Laue } from 'laue'
import moment from 'moment'

Vue.use(Laue)
Vue.prototype.moment = moment

export default {
    name: 'line-chart',

    props: {
        views: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            trans: JSON.parse(Canvas.lang),
            isReady: false,
            values: [],
        }
    },

    mounted() {
        this.plotDataPoints(this.views)

        this.isReady = true
    },

    methods: {
        /**
         * Plot the data and assign labels to the axis.
         *
         * @param data
         */
        plotDataPoints(data) {
            Object.keys(data).forEach(key => {
                this.values.push({ date: key, views: data[key] })
            })
        },

        formatXAxis(value) {
            return moment(value).format('MMM Do')
        },

        formatYAxis(value) {
            return Math.round(value)
        },
    },
}
</script>

<style scoped>
.tooltip {
    background: rgba(0, 0, 0, 0.8);
    border-radius: 4px;
}

.title {
    padding: 10px;
    color: #959da5;
}

.list {
    list-style: none;
    display: flex;
}

.list li {
    padding: 5px 10px;
    flex: 1;
    color: #fff;
    margin: 0;
    min-width: 90px;
}

.list li::before {
    content: none;
}

.label {
    color: #dfe2e5;
    font-weight: 600;
}

.value {
    color: #959da5;
}
</style>
