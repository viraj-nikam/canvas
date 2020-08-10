import Vue from 'vue';
import Vuex from 'vuex';
import config from './modules/config';
import post from './modules/post';
import auth from './modules/auth';
import tag from './modules/tag';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,
        config,
        post,
        tag,
    },
});
