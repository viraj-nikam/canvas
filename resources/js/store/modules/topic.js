import Vue from 'vue';
import request from '../../mixins/request';
import router from 'vue-router';
import toast from '../../mixins/toast';

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
                toast.methods.toast(context.rootState.settings.i18n.saved);
            })
            .catch((error) => {
                state.errors = error.response.data.errors;
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
    },

    RESET_STATE(state) {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
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
