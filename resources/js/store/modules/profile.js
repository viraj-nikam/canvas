import isEmpty from 'lodash/isEmpty';
import request from '../../mixins/request';
import url from '../../mixins/url';

const initialState = {
    id: window.Canvas.user.id,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    username: window.Canvas.user.username,
    summary: window.Canvas.user.summary,
    avatar: window.Canvas.user.avatar || window.Canvas.user.default_avatar,
    darkMode: window.Canvas.user.dark_mode,
    digest: window.Canvas.user.digest,
    locale: window.Canvas.user.locale || window.Canvas.user.default_locale,
    role: window.Canvas.user.role,
    defaultAvatar: window.Canvas.user.default_avatar,
    defaultLocale: window.Canvas.user.default_locale,
    updatedAt: window.Canvas.user.updated_at,
};

const state = { ...initialState };

const actions = {
    updateDigest(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DIGEST', data.user);
            });
    },

    updateLocale(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_LOCALE', data.user);
                context.dispatch('settings/updateLocale', data, { root: true });
            });
    },

    updateDarkMode(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DARK_MODE', data.user);
            });
    },

    setAvatar(context, payload) {
        let path = isEmpty(payload) ? url.methods.gravatar(state.email) : payload;

        context.commit('SET_AVATAR', path);
    },
};

const mutations = {
    UPDATE_DIGEST(state, user) {
        state.digest = user.digest;
    },

    UPDATE_LOCALE(state, user) {
        state.locale = user.locale;
    },

    UPDATE_DARK_MODE(state, user) {
        state.darkMode = user.dark_mode;
    },

    SET_AVATAR(state, url) {
        state.avatar = url;
    },
};

const getters = {
    isContributor(state) {
        return state.role === 1;
    },

    isEditor(state) {
        return state.role === 2;
    },

    isAdmin(state) {
        return state.role === 3;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
