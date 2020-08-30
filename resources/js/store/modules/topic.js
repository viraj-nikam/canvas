import Vue from 'vue';
import request from '../../mixins/request';
import router from '../../router';

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
                context.dispatch('search/buildIndex', true, { root: true });
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
            .then(() => {
                context.commit('RESET_STATE');
                context.dispatch('search/buildIndex', true, { root: true });
                Vue.toasted.show(context.rootGetters['settings/trans'].success, {
                    className: 'bg-success',
                });
                router.push({ name: 'topics' });
            })
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
        state.updatedAt = topic.updated_at;
        state.errors = [];
    },

    RESET_STATE(state) {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    activeTopic(state) {
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
