import request from '../../mixins/request';
import md5 from 'md5';

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
    errors: [],
    isSaving: false,
    hasSuccess: false,
};

const state = { ...initialState };

const actions = {
    async fetchUser(context, id) {
        request.methods
            .request()
            .get('/api/users/' + id)
            .then((response) => {
                context.commit('SET_USER', response.data);
            })
            .catch((errors) => {
                state.errors.push(errors.response.data.errors);
            });
    },

    updateUser(context, payload) {
        context.commit('SET_PENDING', true);

        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then((response) => {
                context.commit('SET_PENDING', false);
                context.commit('SET_SUCCESS', true);
                context.commit('UPDATE_USER', response.data);
            })
            .catch((errors) => {
                context.commit('SET_PENDING', false);
                state.errors.push(errors.response.data.errors);
            });
    },

    updateUserSilently(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then((response) => {
                context.commit('UPDATE_USER', response.data);
            })
            .catch((errors) => {
                state.errors.push(errors.response.data.errors);
            });
    },

    setAvatar(context, payload) {
        context.commit('SET_AVATAR', payload);
    },

    setDefaultAvatar(context) {
        let hash = md5(state.email.trim().toLowerCase());

        context.commit('SET_AVATAR', 'https://secure.gravatar.com/avatar/' + hash + '?s=200');
    },
};

const mutations = {
    SET_USER(state, user) {
        state = user;
    },

    SET_AVATAR(state, url) {
        state.avatar = url;
    },

    SET_PENDING(state, bool) {
        state.isSaving = bool;
    },

    SET_SUCCESS(state, bool) {
        state.hasSuccess = bool;

        setTimeout(() => {
            state.hasSuccess = !bool;
        }, 3000);
    },

    UPDATE_USER(state, user) {
        state = user;
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
