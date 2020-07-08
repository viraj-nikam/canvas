import request from '../../mixins/request';
import toast from '../../mixins/toast';
import config from './config';
import url from '../../mixins/url';

const initialState = {
    avatar: '',
    darkMode: 0,
    locale: '',
    id: null,
    name: '',
    email: '',
    username: '',
    summary: '',
    digest: 0,
    admin: 0,
    errors: [],
};

const state = { ...initialState };

const actions = {
    async fetchUser(context, id) {
        request.methods
            .request()
            .get('/api/users/' + id)
            .then(({ data }) => {
                context.commit('SET_USER', data);
            });
    },

    updateUser(context, payload) {
        request.methods
            .request()
            .post('/api/users/' + state.id, payload)
            .then(({ data }) => {
                context.commit('SET_USER', data);

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
            .then(({ data }) => {
                context.commit('SET_USER', data);
            });
    },

    setAvatar(context, payload) {
        context.commit('SET_AVATAR', payload);
    },

    resetAvatar(context) {
        context.commit('SET_AVATAR', url.methods.gravatar(state.email));
    },

    resetState(context) {
        context.commit('RESET_STATE');
    }
};

const mutations = {
    SET_USER(state, data) {
        state.avatar = data.meta.avatar;
        state.darkMode = data.meta.dark_mode;
        state.locale = data.meta.locale;
        state.id = data.user.id;
        state.name = data.user.name;
        state.email = data.user.email;
        state.username = data.meta.username;
        state.summary = data.meta.summary;
        state.digest = data.meta.digest;
        state.admin = data.meta.admin;
    },

    SET_AVATAR(state, url) {
        state.avatar = url;
    },

    RESET_STATE(state) {
        state = { ...initialState };
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
