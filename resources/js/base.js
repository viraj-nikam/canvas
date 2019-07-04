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
         * @param text
         * @return string
         * @source https://gist.github.com/mathewbyrne/1280286
         */
        slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/--+/g, '-');
        },

        /**
         * Return a number formatted with a suffix.
         *
         * @param number
         * @returns {string}
         */
        suffixedNumber(number) {
            let formatted = '';
            let suffix = '';

            if (number < 900) {
                formatted = number;
                suffix = '';
            } else if (number < 900000) {
                let n_total = number / 1000;
                formatted = parseFloat(n_total.toFixed(1));
                suffix = 'K';
            } else if (number < 900000000) {
                let n_total = number / 1000000;
                formatted = parseFloat(n_total.toFixed(1));
                suffix = 'M';
            } else if (number < 900000000000) {
                let n_total = number / 1000000000;
                formatted = parseFloat(n_total.toFixed(1));
                suffix = 'B';
            } else {
                let n_total = number / 1000000000000;
                formatted = parseFloat(n_total.toFixed(1));
                suffix = 'T';
            }

            return formatted + suffix;
        },

        /**
         * Get the plural form of a word.
         *
         * @param string
         * @param count
         * @returns {string}
         */
        pluralize(string, count) {
            if (count > 1 || count === 0) {
                return ' ' + string + 's';
            } else {
                return ' ' + string;
            }
        },

        /**
         * Create an HTTP request.
         *
         * @returns {AxiosInstance}
         */
        request() {
            let instance = axios.create();

            instance.defaults.baseURL = '/' + Canvas.path;

            instance.interceptors.response.use(
                response => response,
                error => {
                    switch (error.response.status) {
                        case 500:
                            Bus.$emit('httpError', error.response.data.message);
                            break;

                        case 405:
                        case 401:
                            window.location.href = instance.defaults.baseURL;
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
