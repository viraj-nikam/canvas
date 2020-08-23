import Vue from 'vue';

const initialState = {
    id: '',
    title: '',
    slug: '',
    summary: '',
    body: '',
    published_at: '',
    featured_image: '',
    featured_image_caption: '',
    meta: {
        description: '',
        title: '',
        canonical_link: '',
    },
    tags: [],
    topic: [],
};

const state = { ...initialState };

const actions = {
    async fetchPost(context, id) {
        this.request()
            .get('/api/posts/' + id)
            .then((response) => {
                context.commit('SET_POST', response.data.post);
            })
            .catch(() => {
                // Add any error debugging...
            });
    },

    updatePost({ id, payload }) {
        this.request()
            .post('/api/posts/' + id, payload)
            .then((response) => {
                console.log(response.data);
            })
            .catch(() => {
                // Add any error debugging...
            });
    },

    setTags({ context, tags }) {
        context.commit('SET_TAGS', tags);
    },

    setTopic({ context, topic }) {
        context.commit('SET_TOPIC', topic);
    },

    deletePost({ id }) {
        this.request()
            .delete('/api/posts/' + id, id)
            .then((response) => {
                console.log(response.data);
            })
            .catch(() => {
                // Add any error debugging...
            });
    },

    resetPost({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    SET_POST(state, post) {
        state.id = post.id;
        state.title = post.title;
        state.slug = post.slug;
        state.summary = post.summary;
        state.body = post.body;
        state.published_at = post.published_at;
        state.featured_image = post.featured_image;
        state.featured_image_caption = post.featured_image_caption;
    },

    SET_TAGS(state, tags) {
        state.tags = tags;
    },

    SET_TOPIC(state, topic) {
        state.topic = topic;
    },

    RESET_STATE() {
        Object.keys(state).forEach((key) => {
            Object.assign(state[key], initialState[key]);
        });
    },
};

const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
