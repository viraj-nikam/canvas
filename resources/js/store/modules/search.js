import Vue from 'vue';
import profile from './profile';
import request from '../../mixins/request';

const initialState = {
    searchIndex: [],
};

const state = { ...initialState };

const actions = {
    updateIndex(context) {
        request.methods
            .request()
            .get('/api/search/posts')
            .then(({ data }) => {
                context.commit('UPDATE_INDEX', data);
            });

        if (profile.getters.isAdmin) {
            request.methods
                .request()
                .get('/api/search/tags')
                .then(({ data }) => {
                    context.commit('UPDATE_INDEX', data);
                });
            request.methods
                .request()
                .get('/api/search/topics')
                .then(({ data }) => {
                    context.commit('UPDATE_INDEX', data);
                });
            request.methods
                .request()
                .get('/api/search/users')
                .then(({ data }) => {
                    context.commit('UPDATE_INDEX', data);
                });
        }
    },

    resetState({ commit }) {
        commit('RESET_STATE');
    },
};

const mutations = {
    UPDATE_INDEX(state, data) {
        state.searchIndex.push(...data);
    },

    RESET_STATE(state) {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    //
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
