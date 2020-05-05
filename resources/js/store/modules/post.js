import get from 'lodash/get';

export default {
    namespaced: true,
    state: {
        activePost: {},
    },
    getters: {
        activePost(state) {
            return state.activePost;
        },
    },
    actions: {
        setActivePost(context, payload) {
            context.commit('setActivePost', payload);
        },

        updatePostBody(context, body) {
            context.commit('updatePostBody', body);
        },

        saveActivePost(context, payload) {
            context.commit('saveActivePost', payload);
        },

        setPostTags(context, payload) {
            context.commit('setPostTags', payload);
        },

        setPostTopic(context, payload) {
            context.commit('setPostTopic', payload);
        },

        deletePost(context, payload) {
            context.commit('deletePost', payload);
        },
    },
    mutations: {
        setActivePost(state, data) {
            let payload = {};

            payload.id = get(data, 'id', 'create');
            payload.title = get(data, 'title', '');
            payload.slug = get(data, 'slug', '');
            payload.summary = get(data, 'summary', '');
            payload.body = get(data, 'body', '');
            payload.published_at = get(data, 'published_at', '');
            payload.featured_image = get(data, 'featured_image', '');
            payload.featured_image_caption = get(data, 'featured_image_caption', '');

            payload.meta = {};
            payload.meta.description = get(data, 'meta.description', '');
            payload.meta.title = get(data, 'meta.title', '');
            payload.meta.canonical_link = get(data, 'meta.canonical_link', '');

            payload.topic = get(data, 'topic.0', []);
            payload.tags = get(data, 'tags', []);
            payload.errors = [];
            payload.isSaving = false;
            payload.hasSuccess = false;

            state.activePost = payload;
        },

        updatePostBody(state, data) {
            state.activePost.body = data;
        },

        saveActivePost(state, payload) {
            let id = this.$app.$route.name === 'posts-create' ? payload.data.id : payload.id;

            this.$app
                .request()
                .post('/api/posts/' + id, payload.data)
                .then((response) => {
                    if (this.$app.$route.name === 'posts-create') {
                        this.$app.$router.push({
                            name: 'posts-edit',
                            params: { id: response.data.id },
                        });
                    }

                    state.activePost.isSaving = false;
                    state.activePost.hasSuccess = true;
                    state.activePost.post = response.data;
                })
                .catch((error) => {
                    state.activePost.isSaving = false;
                    state.activePost.errors = error.response.data.errors;
                });
        },

        setPostTags(state, tags) {
            state.activePost.tags = tags;
        },

        setPostTopic(state, topic) {
            state.activePost.topic = topic;
        },

        deletePost(state, postId) {
            this.$app
                .request()
                .delete('/api/posts/' + postId)
                .then(() => {
                    state.activePost = {};

                    this.$app.$router.push({ name: 'posts' });
                })
                .catch(() => {});
        },
    },
};
