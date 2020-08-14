import { store } from '../store';
import { sync } from 'vuex-router-sync';
import NProgress from 'nprogress';
import Router from 'vue-router';
import Vue from 'vue';
import routes from './routes';

Vue.use(Router);

NProgress.configure({
    showSpinner: false,
    easing: 'ease',
    speed: 300,
});

const router = createRouter();

sync(store, router);

export default router;

function createRouter() {
    const router = new Router({
        base: store.state.config.path,
        mode: 'history',
        routes,
    });

    router.beforeEach((to, from, next) => {
        NProgress.start();
        next();
    });

    return router;
}
