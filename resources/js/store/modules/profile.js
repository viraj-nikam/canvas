import isEmpty from 'lodash/isEmpty';
import url from '../../mixins/url';

const initialState = {
    id: window.Canvas.user.id,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    avatar: window.Canvas.user.avatar,
    username: window.Canvas.user.username,
    summary: window.Canvas.user.summary,
    role: window.Canvas.user.role_id,
};

const state = { ...initialState };

const actions = {
    setAvatar(context, payload) {
        let path = isEmpty(payload) ? url.methods.gravatar(state.email) : payload;

        context.commit('SET_AVATAR', path);
    },
};

const mutations = {
    SET_AVATAR(state, url) {
        state.avatar = url;
    },
};

const getters = {
    isContributor(state) {
        return state.role === 1;
    },

    isEditor(state) {
        return state.role === 2;
    },

    isAdmin(state) {
        return state.role === 3;
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
