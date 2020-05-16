import request from "../../mixins/request";

const initialState = {
    avatar: window.Canvas.user.avatar,
    darkMode: window.Canvas.user.darkMode,
    locale: window.Canvas.user.locale,
    id: window.Canvas.user.id,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    username: window.Canvas.user.username,
    summary: window.Canvas.user.summary,
    digest: window.Canvas.user.digest,
};

const state = { ...initialState };

const actions = {
    async fetchUser(context, id) {
        request.methods.request()
            .get('/api/users/' + id)
            .then((response) => {
                context.commit('SET_USER', response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },

    updateUser(context, payload) {
        request.methods.request()
            .post('/api/users/' + state.id, payload)
            .then((response) => {
                context.commit('UPDATE_USER', response.data);
            })
            .catch((errors) => {
                console.log(errors);
            })
    }
};

const mutations = {
    SET_USER(state, user) {
        state = user
    },

    UPDATE_USER(state, user) {
        state = user
    }
};

const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
