<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ trans.posts.forms.settings.header }}
                    </p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.slug.label }}</label>
                            <input type="text" class="form-control border-0 px-0" @input="update" name="slug" v-model="storeState.form.slug" :title="trans.posts.forms.settings.slug.label" :placeholder="trans.posts.forms.settings.slug.placeholder"/>
                            <div v-if="storeState.form.errors.slug" class="invalid-feedback d-block">
                                <strong>{{ storeState.form.errors.slug[0] }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.settings.summary.label }}</label>
                            <textarea-autosize rows="1"
                                               name="summary"
                                               class="form-control border-0 px-0"
                                               v-model="storeState.form.summary"
                                               @input.native="update"
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
                    <button type="button" class="btn btn-link font-weight-bold text-muted" data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import TagSelect from "./TagSelect";
    import TopicSelect from "./TopicSelect";
    import {store} from "../screens/posts/store";
    import VueTextAreaAutosize from "vue-textarea-autosize";

    export default {
        name: "settings-modal",

        props: {
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
            }
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
                storeState: store.state,
                trans: JSON.parse(Canvas.lang)
            };
        },

        mounted() {
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
