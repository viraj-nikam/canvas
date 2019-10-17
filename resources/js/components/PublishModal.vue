<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.publish.header }}</label>
                            <p class="text-muted">
                                {{ trans.posts.forms.publish.subtext.details }}
                                <span class="font-weight-bold">{{ moment.tz.guess() }}</span>
                                {{ trans.posts.forms.publish.subtext.timezone }}.
                            </p>

                            <div class="d-flex flex-row">
                                <select class="input pr-2" v-model="components.month">
                                    <option v-for="value in Array.from({ length: 12 },(_, i) => String(i + 1).padStart(2, '0'))" :value="value">
                                        {{ value }}
                                    </option>
                                </select>
                                <span class="px-1">/</span>
                                <select class="input px-2" v-model="components.day">
                                    <option v-for="value in Array.from({ length: 31 },(_, i) =>String(i + 1).padStart(2,'0'))" :value="value">
                                        {{ value }}
                                    </option>
                                </select>
                                <span class="px-1">/</span>
                                <select class="input px-2" v-model="components.year">
                                    <option v-for="value in Array.from({ length: 15 },(_, i) => i + new Date().getFullYear() - 10)" :value="value">
                                        {{ value }}
                                    </option>
                                </select>
                                <span class="pl-3"> </span>
                                <select class="input px-2" v-model="components.hour">
                                    <option v-for="value in Array.from({ length: 24 },(_, i) => String(i).padStart(2, '0'))" :value="value">
                                        {{ value }}
                                    </option>
                                </select>
                                <span class="px-1">:</span>
                                <select class="input pl-2" v-model="components.minute">
                                    <option v-for="value in Array.from({ length: 60 },(_, i) =>String(i).padStart(2, '0'))" :value="value">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-success font-weight-bold" @click="scheduleOrPublish" data-dismiss="modal">
                        <span v-if="shouldPublish">
                            {{ trans.buttons.posts.publish }}
                        </span>
                        <span v-else>
                            {{ trans.buttons.posts.schedule }}
                        </span>
                    </a>

                    <button type="button" class="btn btn-link text-muted font-weight-bold text-decoration-none" data-dismiss="modal">
                        {{ trans.buttons.general.cancel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import {store} from "../screens/posts/store";

    export default {
        name: "publish-modal",

        data() {
            return {
                components: {
                    day: "",
                    month: "",
                    year: "",
                    hour: "",
                    minute: ""
                },
                result: "",
                storeState: store.state,
                trans: JSON.parse(Canvas.lang)
            };
        },

        mounted() {
            this.generateDatePicker(
                this.storeState.form.published_at || moment().format("YYYY-MM-DD hh:mm:ss")
            );
        },

        watch: {
            value(val) {
                this.generateDatePicker(val);
            },

            components: {
                handler: function () {
                    this.result =
                        this.components.year + "-" +
                        this.components.month + "-" +
                        this.components.day + " " +
                        this.components.hour + ":" +
                        this.components.minute + ":00";
                },

                deep: true
            }
        },

        filters: {
            moment: function (date) {
                return moment.tz(date).format("YYYY-MM-DD hh:mm:ss");
            }
        },

        methods: {
            generateDatePicker(val) {
                let date = moment(val + " Z").utc();

                this.components = {
                    month: date.format("MM"),
                    day: date.format("DD"),
                    year: date.format("YYYY"),
                    hour: date.format("HH"),
                    minute: date.format("mm")
                };
            },

            scheduleOrPublish() {
                this.storeState.form.published_at = this.result;
                this.$parent.save();
            }
        },

        computed: {
            shouldPublish() {
                return moment(this.result).isBefore(moment().format("YYYY-MM-DD hh:mm:ss"));
            }
        }
    };
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
