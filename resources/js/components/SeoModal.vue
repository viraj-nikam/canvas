<template>
    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">{{ trans.posts.forms.seo.header }}</p>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ __('trans.posts.forms.seo.meta') }}</label>
                            <textarea name="meta_description"
                                      class="form-control border-0 px-0"
                                      rows="1"
                                      :placeholder="trans.posts.forms.seo.meta"
                                      :title="trans.posts.forms.seo.meta">{{ $data['meta']['meta_description'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.facebook.title.label }}</label>
                            <input name="og_title"
                                   type="text"
                                   class="form-control border-0 px-0"
                                   :title="trans.posts.forms.seo.facebook.title.label"
                                   value="{{ $data['meta']['og_title'] }}"
                                   :placeholder="trans.posts.forms.seo.facebook.title.placeholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.facebook.description.label }}</label>
                            <textarea name="og_description"
                                      class="form-control border-0 px-0"
                                      rows="1"
                                      :placeholder="trans.posts.forms.seo.facebook.description.placeholder"
                                      :title="trans.posts.forms.seo.facebook.description.label">{{ $data['meta']['og_description'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.title.label }}</label>
                            <input type="text"
                                   class="form-control border-0 px-0"
                                   name="twitter_title"
                                   value="{{ $data['meta']['twitter_title'] }}"
                                   :title="trans.posts.forms.seo.twitter.title.label"
                                   :placeholder="trans.posts.forms.seo.twitter.title.placeholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.twitter.description.label }}</label>
                            <textarea name="twitter_description"
                                      class="form-control border-0 px-0"
                                      rows="1"
                                      :placeholder="trans.posts.forms.seo.twitter.description.placeholder"
                                      :title="trans.posts.forms.seo.twitter.description.label">{{ $data['meta']['twitter_description'] }}</textarea>
                        </div>
                    </div>
                    @isset($data['meta']['canonical_link'])
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.seo.canonical.label }}</label>
                            <input type="text"
                                   class="form-control border-0 px-0"
                                   name="canonical_link"
                                   value="{{ $data['meta']['canonical_link'] }}"
                                   :title="trans.posts.forms.seo.canonical.label"
                                   :placeholder="trans.posts.forms.seo.canonical.placeholder">
                        </div>
                    </div>
                    @endisset
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-link text-muted"
                            data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'seo-modal',

        data() {
            return {
                trans: JSON.parse(Canvas.lang),
            }
        },
    }
</script>
