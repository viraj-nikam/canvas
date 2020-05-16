import store from '../store';

export default {
    computed: {
        i18n() {
            return store.state.config.i18n;
        },
    },
};
