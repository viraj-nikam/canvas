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
    fetchTag(context, id) {
        request.methods
            .request()
            .get(`/api/tags/${id}`)
            .then(({ data }) => {
                context.commit('SET_TAG', data);
            })
            .catch(() => {
                router.push({ name: 'tags' });
            });
    },

    updateTag(context, payload) {
        request.methods
            .request()
            .post(`/api/tags/${payload.id}`, {
                name: payload.name,
                slug: payload.slug,
            })
            .then(({ data }) => {
                context.commit('UPDATE_TAG', data);
                toast.methods.toast(context.rootState.settings.i18n.saved);
            })
            .catch((error) => {
                // state.errors.push(...error.response.data.errors);
                state.errors = error.response.data.errors;
            });
    },

    deleteTag(context, id) {
        request.methods
            .request()
            .delete(`/api/tags/${id}`)
            .catch(() => {
                router.push({ name: 'tags' });
            });
    },

    resetState({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    SET_TAG(state, tag) {
        state.id = tag.id;
        state.name = tag.name || '';
        state.slug = tag.slug || '';
        state.updatedAt = tag.updated_at || '';
    },

    UPDATE_TAG(state, tag) {
        state.id = tag.id;
        state.name = tag.name;
        state.slug = tag.slug;
        state.updatedAt = tag.updated_at || '';
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
