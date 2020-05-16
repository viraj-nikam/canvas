const initialState = {
    avatar: window.Canvas.user.avatar,
    darkMode: window.Canvas.user.darkMode,
    locale: window.Canvas.user.locale,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    username: window.Canvas.user.username,
    summary: window.Canvas.user.summary,
    digest: window.Canvas.user.digest,
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
