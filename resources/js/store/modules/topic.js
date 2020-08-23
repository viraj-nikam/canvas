import Vue from 'vue';
import request from '../../mixins/request';
import router from 'vue-router';

const initialState = {
    id: '',
    name: '',
    slug: '',
    updatedAt: '',
    errors: [],
};

const state = { ...initialState };

const actions = {
    fetchTopic(context, id) {
        request.methods
            .request()
            .get(`/api/topics/${id}`)
            .then(({ data }) => {
                context.commit('SET_TOPIC', data);
            })
            .catch(() => {
                router.push({ name: 'topics' });
            });
    },

    updateTopic(context, payload) {
        request.methods
            .request()
            .post(`/api/topics/${payload.id}`, {
                name: payload.name,
                slug: payload.slug,
            })
            .then(({ data }) => {
                context.commit('UPDATE_TOPIC', data);
                Vue.toasted.show(context.rootGetters['settings/trans'].saved, {
                    className: 'bg-success',
                });
            })
            .catch((error) => {
                state.errors = error.response.data.errors;
                Vue.toasted.show(error.response.data.errors.slug[0], {
                    className: 'bg-danger',
                });
            });
    },

    deleteTopic(context, id) {
        request.methods
            .request()
            .delete(`/api/topics/${id}`)
            .catch(() => {
                router.push({ name: 'topics' });
            });
    },

    resetState({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    SET_TOPIC(state, topic) {
        state.id = topic.id;
        state.name = topic.name || '';
        state.slug = topic.slug || '';
        state.updatedAt = topic.updated_at || '';
    },

    UPDATE_TOPIC(state, topic) {
        state.id = topic.id;
        state.name = topic.name;
        state.slug = topic.slug;
        state.updatedAt = topic.updated_at || '';
        state.errors = [];
    },

    RESET_STATE(state) {
        Object.keys(state).forEach((key) => {
            Object.assign(state[key], initialState[key]);
        });
    },
};

const getters = {
    //
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
