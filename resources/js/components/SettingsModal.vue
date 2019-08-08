<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.settings.header }}</p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.slug.label }}</label>
                            <input type="text" class="form-control border-0 px-0"
                                   name="slug"
                                   v-model="form.slug"
                                   @change="update"
                                   :title="trans.posts.forms.settings.slug.label"
                                   :placeholder="trans.posts.forms.settings.slug.placeholder">
                            <div v-if="form.errors.slug" class="invalid-feedback d-block">
                                <strong>{{ form.errors.slug[0] }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.summary.label }}</label>
                            <textarea-autosize
                                    name="summary"
                                    class="form-control border-0 px-0"
                                    rows="1"
                                    v-model="form.summary"
                                    @change.native="update"
                                    :placeholder="trans.posts.forms.settings.summary.placeholder">
                            </textarea-autosize>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.topic.label }}</label>
                            <topic-select :topics="topics"
                                          :assigned="post.topic">
                            </topic-select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.tags.label }}</label>
                            <tag-select :tags="tags"
                                        :tagged="post.tags">
                            </tag-select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import { Bus } from '../bus';
    import TagSelect from './TagSelect';
    import TopicSelect from './TopicSelect';
    import VueTextAreaAutosize from 'vue-textarea-autosize';

    export default {
        name: 'settings-modal',

        props: {
            input: {
                type: Object,
                required: true
            },

            post: {
                type: Object,
                required: false
            },

            tags: {
                type: Array,
                required: false
            },

            topics: {
                type: Array,
                required: false
            },
        },

        components: {
            TagSelect,
            TopicSelect,
            VueTextAreaAutosize
        },

        data() {
            return {
                allTags: [],
                allTopics: [],
                form: {
                    slug: '',
                    summary: '',
                    topic: [],
                    tags: [],
                    errors: [],
                },
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.form.slug = this.input.slug;
            this.form.summary = this.input.summary;
            this.form.topic = this.input.topic;
            this.form.tags = this.input.tags;
            this.form.errors = this.input.errors;
            this.allTags = this.tags;
            this.allTopics = this.topics;
        },

        methods: {
            update: _.debounce(function (e) {
                Bus.$emit('updating', this.form);
            }, 700)
        },
    }
</script>
