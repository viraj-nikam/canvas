<template>
    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.settings.header }}</p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.slug.label }}</label>
                            <input type="text" class="form-control border-0 px-0"
                                   name="slug"
                                   :value="form.slug"
                                   :title="trans.posts.forms.settings.slug.label"
                                   :placeholder="trans.posts.forms.settings.slug.placeholder">
                            <!--                            @if ($errors->has('slug'))-->
                            <!--                            <div class="invalid-feedback d-block">-->
                            <!--                                <strong>{{ $errors->first('slug') }}</strong>-->
                            <!--                            </div>-->
                            <!--                            @endif-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.summary.label }}</label>
                            <textarea-autosize
                                    name="summary"
                                    class="form-control border-0 px-0"
                                    rows="1"
                                    :placeholder="trans.posts.forms.editor.title"
                                    v-model="form.summary">
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
                    <button type="button"
                            class="btn btn-link text-muted"
                            data-dismiss="modal"
                            @click.prevent="closeModal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TagSelect from './TagSelect';
    import TopicSelect from './TopicSelect';
    import VueTextAreaAutosize from 'vue-textarea-autosize';

    export default {
        name: 'settings-modal',

        props: {
            input: {
                type: Object,
                required: false
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
                    tags: []
                },
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.form = this.input;
            this.allTags = this.tags;
            this.allTopics = this.topics;
        },

        methods: {
            closeModal() {
                this.$emit('updating');
            }
        },
    }
</script>
