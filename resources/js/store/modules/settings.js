import request from '../../mixins/request';

const initialState = {
    i18n: window.Canvas.translations,
    languageCodes: window.Canvas.languageCodes,
    maxUpload: window.Canvas.maxUpload,
    path: window.Canvas.path,
    timezone: window.Canvas.timezone,
    unsplash: window.Canvas.unsplash,
    version: window.Canvas.version,
    digest: window.Canvas.user.digest,
    darkMode: window.Canvas.user.darkMode,
    locale: window.Canvas.user.locale,
};

const state = { ...initialState };

const actions = {
    updateDigest(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${context.rootState.profile.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DIGEST', data.meta);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },

    updateLocale(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${context.rootState.profile.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_LOCALE', data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },

    updateDarkMode(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${context.rootState.profile.id}`, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DARK_MODE', data.meta);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
};

const mutations = {
    UPDATE_DIGEST(state, meta) {
        state.digest = meta.digest;
    },

    UPDATE_LOCALE(state, data) {
        state.locale = data.meta.locale;
        state.i18n = data.i18n;
    },

    UPDATE_DARK_MODE(state, meta) {
        state.darkMode = meta.dark_mode;
    },
};

const getters = {
    trans(state) {
        return JSON.parse(state.i18n);
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
