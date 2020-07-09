import request from "../../mixins/request";

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

const actions = {
    updateDigest(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DIGEST', data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },

    updateLocale(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
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
            .post('/api/users/' + state.id, payload)
            .then(({ data }) => {
                context.commit('UPDATE_DARK_MODE', data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
};

const mutations = {
    UPDATE_DIGEST(state, payload) {
        state.digest = payload.digest;
    },

    UPDATE_LOCALE(state, payload) {
        state.locale = payload.locale;
    },

    UPDATE_DARK_MODE(state, payload) {
        state.darkMode = payload.dark_mode;
    },
};

const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
