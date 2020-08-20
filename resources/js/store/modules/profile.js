import isEmpty from 'lodash/isEmpty';
import url from '../../mixins/url';

const initialState = {
    id: window.Canvas.user.id,
    name: window.Canvas.user.name,
    email: window.Canvas.user.email,
    avatar: window.Canvas.user.avatar,
    username: window.Canvas.user.username,
    summary: window.Canvas.user.summary,
    admin: window.Canvas.user.admin,
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
    isAdmin(state) {
        return state.admin == true;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
