import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import search from './modules/search';
import settings from './modules/settings';

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        post,
        search,
        settings,
    },
});
