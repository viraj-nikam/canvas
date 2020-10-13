import axios from 'axios';

const initialState = {
    searchIndex: [],
};

const state = { ...initialState };

const actions = {
    buildIndex(context, stale = false) {
        if (stale) {
            context.commit('RESET_STATE');
        }

        // The request here was extracted from request.js since a mixin cannot be
        // pulled into a store module in the same was it is a component. The
        // tradeoff here is that it will not contain error modifiers.
        let baseDomain = context.rootState['settings'].domain || `/${context.rootState['settings'].path}`;

        axios.get(`${baseDomain}/api/search/posts`).then(({ data }) => {
            context.commit('UPDATE_INDEX', data);
        });

        if (context.rootGetters['settings/isAdmin']) {
            axios.get(`${baseDomain}/api/search/tags`).then(({ data }) => {
                context.commit('UPDATE_INDEX', data);
            });
            axios.get(`${baseDomain}/api/search/topics`).then(({ data }) => {
                context.commit('UPDATE_INDEX', data);
            });
            axios.get(`${baseDomain}/api/search/users`).then(({ data }) => {
                context.commit('UPDATE_INDEX', data);
            });
        }
    },
};

const mutations = {
    UPDATE_INDEX(state, data) {
        state.searchIndex.push(...data);
    },

    RESET_STATE(state) {
        state.searchIndex = [];
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
