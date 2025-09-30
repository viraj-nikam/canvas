import { store } from './store';
import Toasted from 'vue-toasted';
import Vue from 'vue';
import moment from 'moment';
import request from './mixins/request';
import router from './router';

require('bootstrap');

window.Popper = require('popper.js').default;

Vue.prototype.moment = moment;

Vue.use(Toasted, {
    position: 'bottom-right',
    theme: 'bubble',
    duration: 2500,
});

Vue.mixin(request);

Vue.config.productionTip = false;

new Vue({
    el: '#canvas',
    router,
    store,
});

// Dynamic document title per route/component
const appName = (window.Canvas && (window.Canvas.canvasName || window.Canvas.appName)) || 'Life';
function setDocTitle(prefix) {
    if (prefix && typeof prefix === 'string' && prefix.trim()) {
        document.title = `${prefix} - ${appName}`;
    } else {
        document.title = appName;
    }
}

router.afterEach((to) => {
    const title = (to.meta && to.meta.title) || '';
    setDocTitle(title);
});

// Expose helper for components to set more specific titles (e.g., entity names)
Vue.prototype.$setDocTitle = setDocTitle;
