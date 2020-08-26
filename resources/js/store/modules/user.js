import request from '../../mixins/request';
import router from '../../router';
import Vue from "vue";
import get from 'lodash/get';

const initialState = {
    id: '',
    name: '',
    email: '',
    avatar: '',
    username: '',
    summary: '',
    admin: false,
    updatedAt: '',
    errors: []
};

const state = { ...initialState };

const actions = {
    fetchUser(context, id) {
        request.methods
            .request()
            .get(`/api/users/${id}`)
            .then(({ data }) => {
                context.commit('SET_USER', data);
            })
            .catch(() => {
                router.push({ name: 'users' });
            });
    },

    resetState({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    SET_USER(state, data) {
        state.id = data.user.id;
        state.name = data.user.name;
        state.email = data.user.email;
        state.avatar = get(data.meta, 'avatar', '');
        state.username = get(data.meta, 'username', '');
        state.summary = get(data.meta, 'summary', '');
        state.admin = get(data.meta, 'admin', '');
        state.updatedAt = get(data.meta, 'updated_at', data.user.updated_at);
    },

    RESET_STATE(state) {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    activeUser(state) {
        return state;
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
