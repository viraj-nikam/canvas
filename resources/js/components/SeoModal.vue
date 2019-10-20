<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ trans.posts.forms.seo.header }}
                    </p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.meta }}</label>
                            <textarea
                                rows="1"
                                ref="meta_description"
                                name="meta_description"
                                class="form-control border-0 px-0 bg-transparent"
                                @input="update"
                                v-model="storeState.form.meta.meta_description"
                                :placeholder="trans.posts.forms.seo.meta">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">
                                {{ trans.posts.forms.seo.facebook.title.label }}
                            </label>
                            <input
                                name="og_title"
                                type="text"
                                @input="update"
                                class="form-control border-0 px-0 bg-transparent"
                                :title="trans.posts.forms.seo.facebook.title.label"
                                v-model="storeState.form.meta.og_title"
                                :placeholder="trans.posts.forms.seo.facebook.title.placeholder"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.facebook.description.label }}</label>
                            <textarea
                                ref="og_description"
                                rows="1"
                                name="og_description"
                                class="form-control border-0 px-0 bg-transparent"
                                @input="update"
                                v-model="storeState.form.meta.og_description"
                                :placeholder="trans.posts.forms.seo.facebook.description.placeholder">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.title.label }}</label>
                            <input
                                type="text"
                                class="form-control border-0 px-0 bg-transparent"
                                name="twitter_title"
                                @input="update"
                                v-model="storeState.form.meta.twitter_title"
                                :title="trans.posts.forms.seo.twitter.title.label"
                                :placeholder="trans.posts.forms.seo.twitter.title.placeholder"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.description.label }}</label>
                            <textarea
                                ref="twitter_description"
                                rows="1"
                                name="twitter_description"
                                class="form-control border-0 px-0 bg-transparent"
                                @input="update"
                                v-model="storeState.form.meta.twitter_description"
                                :placeholder="trans.posts.forms.seo.twitter.description.placeholder">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.canonical.label }}</label>
                            <input
                                type="text"
                                @input="update"
                                class="form-control border-0 px-0 bg-transparent"
                                name="canonical_link"
                                v-model="storeState.form.meta.canonical_link"
                                :title="trans.posts.forms.seo.canonical.label"
                                :placeholder="trans.posts.forms.seo.canonical.placeholder"
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
    import autosize from 'autosize';
    import {store} from "../screens/posts/store";

    export default {
        name: "seo-modal",

        data() {
            return {
                storeState: store.state,
                trans: JSON.parse(Canvas.lang)
            };
        },

        mounted() {
            const meta_description = this.$refs.meta_description;
            const og_description = this.$refs.og_description;
            const twitter_description = this.$refs.twitter_description;

            autosize(meta_description);
            autosize(og_description);
            autosize(twitter_description);
        },

        methods: {
            update: _.debounce(function (e) {
                this.$parent.save();
            }, 900)
        }
    };
</script>
