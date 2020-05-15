import Vue from 'vue';
import { FETCH_POST, POST_DELETE, POST_EDIT, POST_EDIT_TAGS, POST_EDIT_TOPIC, POST_RESET_STATE } from '../actions.type';
import { SET_POST, SET_TAGS, SET_TOPIC, RESET_STATE } from '../mutations.type';

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
    async [FETCH_POST](context, id) {
        this.request()
            .get('/api/posts/' + id)
            .then((response) => {
                context.commit(SET_POST, response.data.post);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    // eslint-disable-next-line no-unused-vars
    [POST_EDIT]({ context, id, payload }) {
        this.request()
            .post('/api/posts/' + id, payload)
            .then((response) => {
                console.log(response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    [POST_EDIT_TAGS]({ context, tags }) {
        context.commit(SET_TAGS, tags);
    },
    [POST_EDIT_TOPIC]({ context, topic }) {
        context.commit(SET_TOPIC, topic);
    },
    // eslint-disable-next-line no-unused-vars
    [POST_DELETE]({ context, id }) {
        this.request()
            .delete('/api/posts/' + id, id)
            .then((response) => {
                console.log(response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    [POST_RESET_STATE]({ commit }) {
        commit(RESET_STATE);
    },
};

const mutations = {
    [SET_POST](state, post) {
        state = post;
    },
    [SET_TAGS](state, tags) {
        state.tags = tags;
    },
    [SET_TOPIC](state, topic) {
        state.topic = topic;
    },
    [RESET_STATE]() {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    post(state) {
        return state;
    },
};

export default {
    state,
    actions,
    mutations,
    getters,
};
