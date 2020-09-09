const initialState = {
    i18n: window.Canvas.translations,
    languageCodes: window.Canvas.languageCodes,
    maxUpload: window.Canvas.maxUpload,
    path: window.Canvas.path,
    timezone: window.Canvas.timezone,
    unsplash: window.Canvas.unsplash,
    version: window.Canvas.version,
    roles: window.Canvas.roles,
};

const state = { ...initialState };

const actions = {
    updateLocale(context, payload) {
        context.commit('UPDATE_LOCALE', payload);
    },
};

const mutations = {
    UPDATE_LOCALE(state, data) {
        state.i18n = data.i18n;
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
