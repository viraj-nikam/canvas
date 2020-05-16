import Vue from 'vue';
import Vuex from 'vuex';
import config from './modules/config';
import post from './modules/post';
import tag from './modules/tag';
import topic from './modules/topic';
import user from './modules/user';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        config,
        post,
        tag,
        topic,
        user,
    },
});
