import router from './router';
import Vue from 'vue';
import App from './components/App';

require('bootstrap');

window.Popper = require('popper.js').default;

Vue.config.productionTip = false;

new Vue({
    el: '#canvas',
    router,
    ...App,
});
