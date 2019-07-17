<template>
    <div v-cloak>
        <div class="d-flex flex-row">
            <select class="input pr-2" v-model="dateElements.month">
                <option v-for="value in Array.from({length: 12}, (_, i) => String(i + 1).padStart(2, '0'))"
                        :value="value">{{ value }}
                </option>
            </select>
            <span class="px-1">/</span>
            <select class="input px-2" v-model="dateElements.day">
                <option v-for="value in Array.from({length: 31}, (_, i) => String(i + 1).padStart(2, '0'))"
                        :value="value">{{ value }}
                </option>
            </select>
            <span class="px-1">/</span>
            <select class="input px-2" v-model="dateElements.year">
                <option v-for="value in Array.from({length: 15}, (_, i) => i + (new Date()).getFullYear() - 10)"
                        :value="value">{{ value }}
                </option>
            </select>
            <span class="pl-3"> </span>
            <select class="input px-2" v-model="dateElements.hour">
                <option v-for="value in Array.from({length: 24}, (_, i) => String(i).padStart(2, '0'))" :value="value">
                    {{ value }}
                </option>
            </select>
            <span class="px-1">:</span>
            <select class="input pl-2" v-model="dateElements.minute">
                <option v-for="value in Array.from({length: 60}, (_, i) => String(i).padStart(2, '0'))" :value="value">
                    {{ value }}
                </option>
            </select>
        </div>

        <input hidden type="hidden" name="published_at" v-model="result">
    </div>
</template>

<script>
    import moment from 'moment'

    /**
     * Create the default date/time picker.
     *
     * @author Mohamed Said <themsaid@gmail.com>
     */
    export default {
        name: 'datetime-picker',

        props: {
            value: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                dateElements: {
                    day: '',
                    month: '',
                    year: '',
                    hour: '',
                    minute: '',
                },

                result: ''
            }
        },

        mounted() {
            this.generateDatePicker(this.value);
        },

        watch: {
            value(val) {
                this.generateDatePicker(val);
            },

            dateElements: {
                handler: function () {
                    this.result = this.dateElements.year
                        + '-' + this.dateElements.month
                        + '-' + this.dateElements.day
                        + ' ' + this.dateElements.hour
                        + ':' + this.dateElements.minute
                        + ':00';

                    this.$emit('input', this.result);
                },
                deep: true
            },
        },

        methods: {
            generateDatePicker(val) {
                let date = moment(val + ' Z').utc();

                this.dateElements = {
                    month: date.format('MM'),
                    day: date.format('DD'),
                    year: date.format('YYYY'),
                    hour: date.format('HH'),
                    minute: date.format('mm')
                };
            }
        }
    }
</script>

<style scoped>
    select {
        width: auto;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .input {
        border: none;
        background-color: transparent;
    }
</style>
