const initialState = {
    id: window.Canvas.user.id,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    avatar: window.Canvas.user.avatar,
    digest: window.Canvas.user.digest,
    darkMode: window.Canvas.user.darkMode,
    locale: window.Canvas.user.locale,
    admin: window.Canvas.user.admin,
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
