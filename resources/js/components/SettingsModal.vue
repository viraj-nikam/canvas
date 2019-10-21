<template>
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ trans.posts.forms.settings.header }}
                    </p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.slug.label }}</label>
                            <input
                                type="text"
                                class="form-control border-0 px-0 bg-transparent"
                                @input="update"
                                name="slug"
                                v-model="activePost.slug"
                                :title="trans.posts.forms.settings.slug.label"
                                :placeholder="trans.posts.forms.settings.slug.placeholder"
                            />
                            <div v-if="activePost.errors.slug" class="invalid-feedback d-block">
                                <strong>{{ activePost.errors.slug[0] }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.summary.label }}</label>
                            <textarea
                                rows="1"
                                id="settings"
                                name="summary"
                                class="form-control border-0 px-0 bg-transparent resize-none"
                                v-model="activePost.summary"
                                @input="update"
                                :placeholder="trans.posts.forms.settings.summary.placeholder">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.topic.label }}</label>
                            <topic-select
                                :topics="topics"
                                :assigned="activePost.topic"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.tags.label }}</label>
                            <tag-select
                                :tags="tags"
                                :tagged="activePost.tags"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link font-weight-bold text-muted text-decoration-none" data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import $ from 'jquery';
    import autosize from 'autosize';
    import TagSelect from "./TagSelect";
    import TopicSelect from "./TopicSelect";
    import { mapState } from 'vuex';

    export default {
        name: "settings-modal",

        props: {
            tags: {
                type: Array,
                required: false
            },
            topics: {
                type: Array,
                required: false
            }
        },

        components: {
            TagSelect,
            TopicSelect
        },

        data() {
            return {
                allTags: [],
                allTopics: [],
                trans: JSON.parse(Canvas.lang),
            };
        },

        computed: mapState(['activePost']),

        mounted() {
            $('#settingsModal').on('shown.bs.modal', function(){
                autosize($('#settings'));
            });

            this.allTags = this.tags;
            this.allTopics = this.topics;
        },

        methods: {
            update: _.debounce(function (e) {
                this.$parent.save();
            }, 900)
        }
    };
</script>
