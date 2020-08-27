<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between border-0">
                    <h4 class="modal-title">{{ trans.app.seo_settings }}</h4>

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
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                {{ trans.app.meta_title }}
                                <a
                                    v-tooltip="{ placement: 'right' }"
                                    href="#"
                                    class="text-decoration-none"
                                    :title="trans.app.sync_with_post_title"
                                    @click.prevent="syncTitle"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        class="icon-refresh"
                                        width="25"
                                    >
                                        <circle cx="12" cy="12" r="10" style="fill: none" />
                                        <path
                                            class="fill-light-gray"
                                            d="M8.52 7.11a5.98 5.98 0 0 1 8.98 2.5 1 1 0 1 1-1.83.8 4 4 0 0 0-5.7-1.86l.74.74A1 1 0 0 1 10 11H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1.7-.7l.82.81zm5.51 8.34l-.74-.74A1 1 0 0 1 14 13h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1.7.7l-.82-.81A5.98 5.98 0 0 1 6.5 14.4a1 1 0 1 1 1.83-.8 4 4 0 0 0 5.7 1.85z"
                                        />
                                    </svg>
                                </a>
                            </label>
                            <input
                                v-model="activePost.meta.title"
                                name="title"
                                type="text"
                                class="form-control border-0"
                                :title="trans.app.meta_title"
                                :placeholder="trans.app.meta_title_placeholder"
                                @input="update"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                {{ trans.app.meta_description }}
                                <a
                                    v-tooltip="{ placement: 'right' }"
                                    href="#"
                                    class="text-decoration-none"
                                    :title="trans.app.sync_with_post_description"
                                    @click.prevent="syncDescription"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        class="icon-refresh"
                                        width="25"
                                    >
                                        <circle cx="12" cy="12" r="10" style="fill: none" />
                                        <path
                                            class="fill-light-gray"
                                            d="M8.52 7.11a5.98 5.98 0 0 1 8.98 2.5 1 1 0 1 1-1.83.8 4 4 0 0 0-5.7-1.86l.74.74A1 1 0 0 1 10 11H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1.7-.7l.82.81zm5.51 8.34l-.74-.74A1 1 0 0 1 14 13h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1.7.7l-.82-.81A5.98 5.98 0 0 1 6.5 14.4a1 1 0 1 1 1.83-.8 4 4 0 0 0 5.7 1.85z"
                                        />
                                    </svg>
                                </a>
                            </label>
                            <textarea
                                v-model="activePost.meta.description"
                                id="description"
                                rows="4"
                                name="description"
                                style="resize: none"
                                class="form-control border-0"
                                :placeholder="trans.app.meta_description_placeholder"
                                @input="update"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                {{ trans.app.canonical_link }}
                            </label>
                            <input
                                v-model="activePost.meta.canonical_link"
                                type="text"
                                class="form-control border-0"
                                name="canonical_link"
                                :title="trans.app.canonical_link"
                                :placeholder="trans.app.canonical_link_placeholder"
                                @input="update"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                        data-dismiss="modal"
                    >
                        {{ trans.app.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import Tooltip from '../../directives/Tooltip';
import debounce from 'lodash/debounce';

export default {
    name: 'seo-modal',

    directives: {
        Tooltip,
    },

    data() {
        return {
            trans: JSON.parse(window.Canvas.locale.translations),
        };
    },

    computed: mapState(['activePost']),

    methods: {
        update: debounce(function () {
            this.$parent.save();
        }, 3000),

        syncDescription() {
            this.activePost.meta.description = this.activePost.summary;
            this.$parent.save();
        },

        syncTitle() {
            this.activePost.meta.title = this.activePost.title;
            this.$parent.save();
        },
    },
};
</script>
