import axios from 'axios';
import {Bus} from './bus.js';

export default {
    computed: {
        Canvas() {
            return Canvas;
        },
    },

    methods: {
        /**
         * Trim an alphanumeric string and convert to a slug.
         *
         * @source https://gist.github.com/mathewbyrne/1280286
         */
        slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/--+/g, '-')
        },

        http() {
            let instance = axios.create();

            instance.defaults.baseURL = '/' + Canvas.path;

            instance.interceptors.response.use(
                response => response,
                error => {
                    switch (error.response.status) {
                        case 500:
                            Bus.$emit('httpError', error.response.data.message);
                            break;

                        case 401:
                            window.location.href = '/' + Canvas.path + '/logout';
                            break;
                    }

                    return Promise.reject(error);
                }
            );

            return instance;
        },

        alertError(message) {
            this.$root.alert.type = 'error';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
        },

        alertConfirm(message, success, failure) {
            this.$root.alert.type = 'confirmation';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
            this.$root.alert.confirmationProceed = success;
            this.$root.alert.confirmationCancel = failure;
        },

        notifySuccess(message, autoClose) {
            this.$root.notification.type = 'success';
            this.$root.notification.autoClose = autoClose;
            this.$root.notification.message = message;
        },
    }
};
