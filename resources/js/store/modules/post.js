import Vue from 'vue';
import request from '../../mixins/request';
import router from '../../router';

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
    fetchPost(context, id) {
        request.methods
            .request()
            .get(`/api/posts/${id}`)
            .then((response) => {
                context.commit('SET_POST', response.data.post);
            })
            .catch(() => {
                router.push({ name: 'posts' });
            });
    },

    updatePost(context, payload) {
        request.methods
            .request()
            .post(`/api/posts/${payload.id}`, payload)
            .then(({ data }) => {
                console.log(data);
            })
            .catch((error) => {
                console.log(error);
            });
    },

    setTags({ context, tags }) {
        context.commit('SET_TAGS', tags);
    },

    setTopic({ context, topic }) {
        context.commit('SET_TOPIC', topic);
    },

    deletePost(context, id) {
        request.methods
            .request()
            .delete(`/api/posts/${id}`)
            .then(() => {
                context.commit('RESET_STATE');
            })
            .catch(() => {
                router.push({ name: 'posts' });
            });
    },

    resetState({ commit }) {
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

    RESET_STATE(state) {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    activePost(state) {
        return state;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
