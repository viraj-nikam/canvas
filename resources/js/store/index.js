import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import search from './modules/search';
import settings from './modules/settings';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        post,
        search,
        settings,
    },
});
