import request from '../../mixins/request';
import md5 from 'md5';
import toast from '../../mixins/toast';
import config from './config';

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
};

const state = { ...initialState };

const actions = {
    async fetchUser(context, id) {
        request.methods
            .request()
            .get('/api/users/' + id)
            .then((response) => {
                context.commit('SET_USER', response.data);
            });
    },

    updateUser(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then((response) => {
                context.commit('UPDATE_USER', response.data);

                toast.methods.toast(config.state.i18n.saved);
            })
            .catch((error) => {
                state.errors.push(error.response.data.errors);
            });
    },

    updateUserSilently(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then((response) => {
                context.commit('UPDATE_USER', response.data);
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
