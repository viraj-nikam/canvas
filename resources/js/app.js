import Vue from 'vue';
import $ from 'jquery';
import axios from 'axios';
import Base from './base';
import Routes from './routes';
import autosize from 'autosize';
import NProgress from 'nprogress';
import VueRouter from 'vue-router';
import moment from 'moment-timezone';

require('bootstrap');
window.Popper = require('popper.js').default;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * Current workaround for using the Autosize library which will only
 * resize elements when clicked, not on the initial page load.
 *
 * @link http://www.jacklmoore.com/autosize/#faq-hidden
 */
$(function () {
    let textarea = $('textarea');

    autosize(textarea);

    textarea.focus(function () {
        autosize.update(textarea);
    });
});

// Set the default app timezone
moment.tz.setDefault(Canvas.timezone);

Vue.mixin(Base);

// Prevent the production tip on Vue startup
Vue.config.productionTip = false;

Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: window.Canvas.path,
});

NProgress.configure({
    showSpinner: false
});

// Start the progress bar animation if not on an initial page load
// todo: is there a way to ignore this when hitting the Load More button on index lists?
router.beforeResolve((to, from, next) => {
    if (to.path) {
        NProgress.start()
    }
    next()
});

// Complete the animation of the route progress bar
router.afterEach(() => {
    NProgress.done()
});

new Vue({
    el: '#canvas',

    router,
});
