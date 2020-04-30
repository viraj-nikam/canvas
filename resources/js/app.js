import NProgress from "nprogress";
import router from "./router";
import Vue from "vue";

require("bootstrap");

window.Popper = require("popper.js").default;

Vue.config.productionTip = false;

NProgress.configure({
    showSpinner: false,
    easing: "ease",
    speed: 300,
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    next();
});

new Vue({
    el: "#canvas",
    router,
});
