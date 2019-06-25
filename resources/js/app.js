import Vue from 'vue';
import axios from 'axios';
import Base from './base';
import {Bus} from './bus.js';
import Routes from './routes';
import NProgress from 'nprogress';
import VueRouter from 'vue-router';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('bootstrap');

window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.autosize = window.autosize ? window.autosize : require('autosize');
window.Popper = require('popper.js').default;

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

/**
 * Initialize all tooltips on a page by manually opting in.
 *
 * @link https://getbootstrap.com/docs/4.3/components/tooltips/#example-enable-tooltips-everywhere
 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);

window.Canvas.basePath = '/' + window.Canvas.path;

let routerBasePath = window.Canvas.basePath + '/';

if (window.Canvas.path === '' || window.Canvas.path === '/') {
    routerBasePath = '/';
    window.Canvas.basePath = '';
}

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: routerBasePath,
});

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load
    if (to.name) {
        // Start the route progress bar
        NProgress.start()
    }
    next()
});

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar
    NProgress.done()
});

Vue.mixin(Base);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
new Vue({
    el: '#canvas',

    router,

    data() {
        return {
            i18n: JSON.parse(Canvas.lang),

            alert: {
                type: null,
                autoClose: 0,
                message: '',
                confirmationProceed: null,
                confirmationCancel: null,
            },

            notification: {
                type: null,
                autoClose: 0,
                message: ''
            }
        }
    },

    mounted() {
        Bus.$on('httpError', message => this.alertError(message));
    },
});
