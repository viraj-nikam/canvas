const initialState = {
    avatar: window.Canvas.avatar,
    darkMode: window.Canvas.darkMode,
    languageCodes: window.Canvas.languageCodes,
    locale: window.Canvas.locale,
    maxUpload: window.Canvas.maxUpload,
    path: window.Canvas.path,
    timezone: window.Canvas.timezone,
    translations: window.Canvas.translations,
    unsplash: window.Canvas.unsplash,
    user: window.Canvas.user,
};

const state = { ...initialState };

const actions = {};

const mutations = {};

const getters = {
    config(state) {
        return state;
    },
};

export default {
    state,
    actions,
    mutations,
    getters,
};
