import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import profile from './modules/profile';
import search from './modules/search';
import settings from './modules/settings';
import tag from './modules/tag';
import topic from './modules/topic';
import user from './modules/user';

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        post,
        profile,
        search,
        settings,
        tag,
        topic,
        user,
    },
});
