import Vue from 'vue';
import get from 'lodash/get';
import request from '../../mixins/request';
import router from '../../router';
import url from '../../mixins/url';

const initialState = {
    id: '',
    name: '',
    email: '',
    username: '',
    summary: '',
    avatar: '',
    darkMode: false,
    digest: false,
    locale: '',
    role: 1,
    updatedAt: '',
    errors: [],
};

const state = { ...initialState };

const actions = {
    fetchUser(context, id) {
        request.methods
            .request()
            .get(`/api/users/${id}`)
            .then(({ data }) => {
                context.commit('SET_USER', data);
            })
            .catch(() => {
                router.push({ name: 'users' });
            });
    },

    updateUser(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${payload.id}`, {
                username: payload.username,
                summary: payload.summary,
                avatar: payload.avatar,
            })
            .then(({ data }) => {
                context.commit('UPDATE_USER', data);
                Vue.toasted.show(context.rootGetters['settings/trans'].saved, {
                    className: 'bg-success',
                });
            })
            .catch((error) => {
                state.errors = error.response.data.errors;
                Vue.toasted.show(error.response.data.errors.username[0], {
                    className: 'bg-danger',
                });
            });
    },

    updateRole(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.id}`, {
                role: payload.role,
            })
            .then(({ data }) => {
                context.commit('UPDATE_ROLE', data);
                Vue.toasted.show(context.rootGetters['settings/trans'].saved, {
                    className: 'bg-success',
                });
            })
            .catch(() => {
                // Add any error debugging...
            });
    },

    resetAvatar({ commit }) {
        commit('RESET_AVATAR');
    },

    resetState({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    SET_USER(state, data) {
        state.id = data.user.id;
        state.name = data.user.name;
        state.email = data.user.email;
        state.avatar = get(data.meta, 'avatar') || url.methods.gravatar(data.user.email);
        state.username = get(data.meta, 'username', '');
        state.summary = get(data.meta, 'summary', '');
        state.role = get(data.meta, 'role', 1);
        state.updatedAt = get(data.meta, 'updated_at', data.user.updated_at);
    },

    UPDATE_USER(state, data) {
        state.id = data.user.id;
        state.name = data.user.name;
        state.email = data.user.email;
        state.avatar = data.meta.avatar;
        state.username = data.meta.username;
        state.summary = data.meta.summary;
        state.role = data.meta.role;
        state.updatedAt = data.meta.updated_at;
        state.errors = [];
    },

    UPDATE_ROLE(state, data) {
        state.role = data.meta.role;
    },

    RESET_AVATAR(state) {
        state.avatar = url.methods.gravatar(state.email);
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
