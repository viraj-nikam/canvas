import Vue from 'vue';
import Base from './base';
import Routes from './routes';
import NProgress from 'nprogress';
import VueRouter from 'vue-router';
import moment from 'moment-timezone';

require ('bootstrap');

window.Popper = require('popper.js').default;

// Set the default app timezone
moment.tz.setDefault(Canvas.timezone);

// Prevent the production tip on Vue startup
Vue.config.productionTip = false;

Vue.mixin(Base);

Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: window.Canvas.path,
});

NProgress.configure({
    showSpinner: false
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    next()
});

router.afterEach(() => {
    NProgress.done();
});

new Vue({
    el: '#canvas',

    router,
});
