import _ from 'lodash';

export const store = {
    state: {
        form: {
            id: '',
            title: '',
            slug: '',
            summary: '',
            body: '',
            published_at: '',
            featured_image: '',
            featured_image_caption: '',
            meta: {
                meta_description: '',
                og_title: '',
                og_description: '',
                twitter_title: '',
                twitter_description: '',
                canonical_link: '',
            },
            topic: [],
            tags: [],
            errors: [],
            isSaving: false,
            hasSuccess: false,
        },
    },

    hydrateForm(data) {
        this.state.form.id = _.get(data, 'id', '');
        this.state.form.title = _.get(data, 'title', '');
        this.state.form.slug = _.get(data, 'slug', '');
        this.state.form.summary = _.get(data, 'summary', '');
        this.state.form.body = _.get(data, 'body', '');
        this.state.form.published_at = _.get(data, 'published_at', '');
        this.state.form.featured_image = _.get(data, 'featured_image', '');
        this.state.form.featured_image_caption = _.get(data, 'featured_image_caption', '');
        this.state.form.meta.meta_description = _.get(data, 'meta.meta_description', '');
        this.state.form.meta.og_title = _.get(data, 'meta.og_title', '');
        this.state.form.meta.og_description = _.get(data, 'meta.og_description', '');
        this.state.form.meta.twitter_title = _.get(data, 'meta.twitter_title', '');
        this.state.form.meta.twitter_description = _.get(data, 'meta.twitter_description', '');
        this.state.form.meta.canonical_link = _.get(data, 'meta.canonical_link', '');
        this.state.form.topic = _.get(data, 'topic', []);
        this.state.form.tags = _.get(data, 'tags', []);
        this.state.form.errors = [];
        this.state.form.isSaving = false;
        this.state.form.hasSuccess = false;
    },

    syncTags(tags) {
        this.state.form.tags = tags;
    },

    syncTopic(topic) {
        this.state.form.topic = topic || [];
    }
};
