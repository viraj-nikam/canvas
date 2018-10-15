import Vue from 'vue';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./bootstrap/alert');
require('./bootstrap/carousel');
require('./bootstrap/collapse');
require('./bootstrap/dropdown');
require('./bootstrap/modal');
require('./bootstrap/popover');
require('./bootstrap/scrollspy');
require('./bootstrap/tab');
require('./bootstrap/tooltip');
require('./bootstrap/util');
require('./custom/affix');
require('./custom/datepicker');
require('./custom/spinner');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('editor', require('./components/Editor.vue'));

new Vue({
    el: '#app'
});