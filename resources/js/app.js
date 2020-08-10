import moment from 'moment';
import request from './mixins/request';
import router from './router';
import Vue from 'vue';
import { store } from './store';
import Canvas from './Canvas';

require('bootstrap');

window.Popper = require('popper.js').default;

Vue.prototype.moment = moment;

Vue.mixin(request);

Vue.config.productionTip = false;

new Vue({
    el: '#canvas',
    router,
    store,
    components: { Canvas },
    template: '<Canvas/>',
});
