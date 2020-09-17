<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <h5 class="modal-title">{{ trans.publishing }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            class="icon-close-circle"
                        >
                            <circle cx="12" cy="12" r="10" class="fill-light-gray" />
                            <path
                                class="fill-bg"
                                d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"
                            />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary text-center text-lg-left">
                        {{ trans.post_scheduling_format }}
                        <span class="font-weight-bold">{{ settings.timezone }}</span>
                        {{ trans.timezone }}. (m/d/y h:m)
                    </p>

                    <div class="row">
                        <div
                            class="col-sm-6 col-12 pb-sm-0 pb-3 pr-sm-0 d-flex justify-content-center justify-content-sm-start"
                        >
                            <div class="d-flex align-items-center">
                                <select
                                    v-model="components.month"
                                    class="w-auto custom-select custom-select-sm border-0"
                                >
                                    <option
                                        v-bind:key="value"
                                        v-for="value in Array.from({ length: 12 }, (_, i) =>
                                            String(i + 1).padStart(2, '0')
                                        )"
                                        :value="value"
                                    >
                                        {{ value }}
                                    </option>
                                </select>

                                <span class="px-1">/</span>
                                <select v-model="components.day" class="w-auto custom-select custom-select-sm border-0">
                                    <option
                                        v-bind:key="value"
                                        v-for="value in Array.from({ length: 31 }, (_, i) =>
                                            String(i + 1).padStart(2, '0')
                                        )"
                                        :value="value"
                                    >
                                        {{ value }}
                                    </option>
                                </select>

                                <span class="px-1">/</span>
                                <select
                                    v-model="components.year"
                                    class="w-auto custom-select custom-select-sm border-0"
                                >
                                    <option
                                        v-bind:key="value"
                                        v-for="value in Array.from(
                                            { length: 15 },
                                            (_, i) => i + new Date().getFullYear() - 10
                                        )"
                                        :value="value"
                                    >
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 pl-sm-0 d-flex justify-content-center justify-content-sm-start">
                            <div class="d-flex align-items-center">
                                <select
                                    v-model="components.hour"
                                    class="w-auto custom-select custom-select-sm border-0"
                                >
                                    <option
                                        v-bind:key="value"
                                        v-for="value in Array.from({ length: 24 }, (_, i) =>
                                            String(i).padStart(2, '0')
                                        )"
                                        :value="value"
                                    >
                                        {{ value }}
                                    </option>
                                </select>

                                <span class="px-1">:</span>
                                <select
                                    v-model="components.minute"
                                    class="w-auto custom-select custom-select-sm border-0"
                                >
                                    <option
                                        v-bind:key="value"
                                        v-for="value in Array.from({ length: 60 }, (_, i) =>
                                            String(i).padStart(2, '0')
                                        )"
                                        :value="value"
                                    >
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <p v-if="isScheduled(post.publishedAt)" class="mt-3 text-success font-italic">
                        {{ trans.your_post_will_publish_at }}
                        {{ moment(post.publishedAt).format('h:mm A') }}
                        {{ trans.on }}
                        {{ moment(post.publishedAt).format('MMMM DD, YYYY') }}.
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-lg order-lg-last px-0">
                            <a
                                v-if="shouldPublish"
                                href="#"
                                class="btn btn-success btn-block font-weight-bold mt-0"
                                data-dismiss="modal"
                                @click="scheduleOrPublish"
                            >
                                {{ trans.publish_now }}
                            </a>

                            <a
                                v-else
                                href="#"
                                class="btn btn-success btn-block font-weight-bold mt-0"
                                @click="scheduleOrPublish"
                            >
                                {{ trans.schedule_to_publish }}
                            </a>
                        </div>

                        <div class="col-lg order-lg-first px-0">
                            <button
                                v-if="isScheduled(post.publishedAt)"
                                type="button"
                                class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
                                data-dismiss="modal"
                                @click="cancelScheduling"
                            >
                                {{ trans.cancel_scheduling }}
                            </button>

                            <button
                                v-else
                                type="button"
                                class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
                                data-dismiss="modal"
                            >
                                {{ trans.cancel }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import moment from 'moment'
import status from '../../mixins/status';

export default {
    name: 'publish-modal',

    mixins: [status],

    data() {
        return {
            components: {
                day: '',
                month: '',
                year: '',
                hour: '',
                minute: '',
            },
            result: '',
        };
    },

    computed: {
        ...mapState(['settings']),
        ...mapGetters({
            trans: 'settings/trans',
        }),
    },

    watch: {
        value(val) {
            this.generateDatePicker(val);
        },

        components: {
            handler: function () {
                this.result =
                    this.components.year +
                    '-' +
                    this.components.month +
                    '-' +
                    this.components.day +
                    ' ' +
                    this.components.hour +
                    ':' +
                    this.components.minute +
                    ':00';
            },

            deep: true,
        },
    },

    mounted() {
        this.generateDatePicker(
            this.post.publishedAt ||
            moment(new Date())
                .format()
                .slice(0, 19)
                .replace('T', ' ')
        )
    },

    methods: {
        shouldPublish() {
            return moment(this.result).isBefore(
                moment(new Date())
                    .format()
                    .slice(0, 19)
                    .replace('T', ' ')
            )
        },

        generateDatePicker(val) {
            let date = moment(val + ' Z').utc();

            this.components = {
                month: date.format('MM'),
                day: date.format('DD'),
                year: date.format('YYYY'),
                hour: date.format('HH'),
                minute: date.format('mm'),
            }
        },

        scheduleOrPublish() {
            this.post.publishedAt = this.result;
            this.$emit('update');
        },

        cancelScheduling() {
            this.post.publishedAt = '';
            this.$emit('update');
        },
    },
};
</script>
