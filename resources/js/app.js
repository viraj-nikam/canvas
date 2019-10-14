import Vue from "vue";
import Routes from "./routes";
import Base from "./mixins/base";
import NProgress from "nprogress";
import VueRouter from "vue-router";
import moment from "moment-timezone";

require("bootstrap");

window.Popper = require("popper.js").default;

Vue.mixin(Base);

// Set the default app timezone
moment.tz.setDefault(Canvas.timezone);

// Prevent the production tip on Vue startup
Vue.config.productionTip = false;

Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: "history",
    base: Canvas.path
});

NProgress.configure({
    showSpinner: false,
    easing: 'ease',
    speed: 300
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    next();
});

router.afterEach(() => {
    NProgress.done();
});

new Vue({
    el: "#canvas",
    router
});
