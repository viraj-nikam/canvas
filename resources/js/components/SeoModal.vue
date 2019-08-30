<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.seo.header }}</p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.meta }}</label>
                            <textarea-autosize
                                name="meta_description"
                                class="form-control border-0 px-0"
                                rows="1"
                                v-model="storeState.form.meta.meta_description"
                                :placeholder="trans.posts.forms.seo.meta">
                            </textarea-autosize>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.facebook.title.label }}</label>
                            <input name="og_title"
                                   type="text"
                                   class="form-control border-0 px-0"
                                   :title="trans.posts.forms.seo.facebook.title.label"
                                   v-model="storeState.form.meta.og_title"
                                   :placeholder="trans.posts.forms.seo.facebook.title.placeholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.facebook.description.label }}</label>
                            <textarea-autosize
                                name="og_description"
                                class="form-control border-0 px-0"
                                rows="1"
                                v-model="storeState.form.meta.og_description"
                                :placeholder="trans.posts.forms.seo.facebook.description.placeholder">
                            </textarea-autosize>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.title.label }}</label>
                            <input type="text"
                                   class="form-control border-0 px-0"
                                   name="twitter_title"
                                   v-model="storeState.form.meta.twitter_title"
                                   :title="trans.posts.forms.seo.twitter.title.label"
                                   :placeholder="trans.posts.forms.seo.twitter.title.placeholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.description.label }}</label>
                            <textarea-autosize
                                name="twitter_description"
                                class="form-control border-0 px-0"
                                rows="1"
                                v-model="storeState.form.meta.twitter_description"
                                :placeholder="trans.posts.forms.seo.twitter.description.placeholder">
                            </textarea-autosize>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.canonical.label }}</label>
                            <input type="text"
                                   class="form-control border-0 px-0"
                                   name="canonical_link"
                                   v-model="storeState.form.meta.canonical_link"
                                   :title="trans.posts.forms.seo.canonical.label"
                                   :placeholder="trans.posts.forms.seo.canonical.placeholder">
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
    import { store } from '../screens/posts/store';
    import VueTextAreaAutosize from 'vue-textarea-autosize';

    export default {
        name: 'seo-modal',

        components: {
            VueTextAreaAutosize
        },

        data() {
            return {
                storeState: store.state,
                trans: JSON.parse(Canvas.lang),
            }
        }
    }
</script>
