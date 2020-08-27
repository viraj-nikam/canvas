import Vue from 'vue';
import get from 'lodash/get';
import request from '../../mixins/request';
import router from '../../router';
import url from '../../mixins/url';

const initialState = {
    id: '',
    name: '',
    email: '',
    avatar: '',
    username: '',
    summary: '',
    admin: false,
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

    updateAdmin(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.id}`, {
                admin: payload.admin,
            })
            .then(({ data }) => {
                context.commit('UPDATE_ADMIN', data);
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
        state.admin = get(data.meta, 'admin', false);
        state.updatedAt = get(data.meta, 'updated_at', data.user.updated_at);
    },

    UPDATE_USER(state, data) {
        state.id = data.user.id;
        state.name = data.user.name;
        state.email = data.user.email;
        state.avatar = data.meta.avatar;
        state.username = data.meta.username;
        state.summary = data.meta.summary;
        state.admin = data.meta.admin;
        state.updatedAt = data.meta.updated_at;
        state.errors = [];
    },

    UPDATE_ADMIN(state, data) {
        state.admin = data.meta.admin;
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
    activeUser(state) {
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
