import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import config from './modules/config';
import post from './modules/post';
import tag from './modules/tag';
import topic from './modules/topic';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,
        config,
        post,
        tag,
        topic,
    },
});
