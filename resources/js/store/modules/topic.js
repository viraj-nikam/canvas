import Vue from 'vue';
import config from './config';
import request from '../../mixins/request';
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
    fetchTag(context, id) {
        request.methods
            .request()
            .get(`/api/topics/${id}`)
            .then(({ data }) => {
                console.log(data);
                context.commit('SET_TOPIC', data);
            });
    },

    updateTag(context, payload) {
        request.methods
            .request()
            .post(`/api/topics/${payload.id}`, {
                name: payload.name,
                slug: payload.slug,
            })
            .then(({ data }) => {
                context.commit('UPDATE_TOPIC', data);
                toast.methods.toast(config.state.i18n.saved);
            })
            .catch((error) => {
                state.errors = error.response.data.errors;
            });
    },

    deleteTag(context, id) {
        request.methods.request().delete(`/api/topics/${id}`);
    },

    resetTag({ commit }) {
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

    RESET_STATE() {
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
