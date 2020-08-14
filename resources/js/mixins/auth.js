import { store } from '../store';

export default {
    methods: {
        userIsAdmin() {
            return store.state.auth.admin === 1;
        },
    },
};
