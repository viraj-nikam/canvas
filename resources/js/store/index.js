import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import tag from './modules/tag';
import topic from './modules/topic';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        post,
        tag,
        topic,
    },
});
