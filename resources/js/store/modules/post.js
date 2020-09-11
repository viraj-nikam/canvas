import Vue from 'vue';
import get from 'lodash/get';
import request from '../../mixins/request';
import router from '../../router';

const initialState = {
    id: '',
    title: '',
    slug: '',
    summary: '',
    body: '',
    publishedAt: '',
    featuredImage: '',
    featuredImageCaption: '',
    meta: {
        description: '',
        title: '',
        canonicalLink: '',
    },
    selectedTags: [],
    selectedTopic: [],
    allTags: [],
    allTopics: [],
    isSaving: false,
    isSaved: false,
    errors: [],
};

const state = { ...initialState };

const actions = {
    fetchPost(context, id) {
        request.methods
            .request()
            .get(`/api/posts/${id}`)
            .then(({ data }) => {
                context.commit('SET_POST', data);
            })
            .catch((error) => {
                console.log(error);
                router.push({ name: 'posts' });
            });
    },

    updatePost(context, payload) {
        request.methods
            .request()
            .post(`/api/posts/${payload.id}`, payload)
            .then(({ data }) => {
                context.commit('SET_POST', data);
            })
            .catch((error) => {
                console.log(error);
            });
    },

    setTags(context, tags) {
        context.commit('SET_TAGS', tags);
    },

    setTopic(context, topic) {
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
    SET_POST(state, data) {
        state.id = data.post.id;
        state.title = get(data.post, 'title', '');
        state.slug = get(data.post, 'slug', '');
        state.summary = get(data.post, 'summary', '');
        state.body = get(data.post, 'body', '');
        state.publishedAt = get(data.post, 'published_at', '');
        state.featuredImage = get(data.post, 'featured_image', '');
        state.featuredImageCaption = get(data.post, 'featured_image_caption', '');
        state.meta.description = get(data.post.meta, 'description', '');
        state.meta.title = get(data.post.meta, 'title', '');
        state.meta.canonicalLink = get(data.post.meta, 'canonical_link', '');
        state.selectedTags = get(data.post, 'tags', []);
        state.selectedTopic = get(data.post, 'topic', []);
        state.allTags = get(data, 'tags', []);
        state.allTopics = get(data, 'topics', []);
    },

    UPDATE_POST(state, post) {
        state.id = post.id;
        state.title = post.title;
        state.slug = post.slug;
        state.summary = post.summary;
        state.body = post.body;
        state.publishedAt = post.published_at;
        state.featuredImage = post.featured_image;
        state.featuredImageCaption = post.featured_image_caption;
    },

    SET_TITLE(state, title) {
        state.title = title;
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
    activeBody(state) {
        return state.body;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
