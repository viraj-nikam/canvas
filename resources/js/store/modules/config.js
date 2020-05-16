const initialState = {
    i18n: JSON.parse(window.Canvas.translations)['app'],
    languageCodes: window.Canvas.languageCodes,
    maxUpload: window.Canvas.maxUpload,
    path: window.Canvas.path,
    timezone: window.Canvas.timezone,
    unsplash: window.Canvas.unsplash,
};

const state = { ...initialState };

const actions = {};

const mutations = {};

const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
