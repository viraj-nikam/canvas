import axios from 'axios';

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
         * Create an base Axios request and set the defaults.
         *
         * @returns {AxiosInstance}
         */
        request() {
            let instance = axios.create();
            let token = document.head.querySelector('meta[name="csrf-token"]');

            instance.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
            instance.defaults.baseURL = '/' + Canvas.path;

            const requestHandler = (request) => {
                // Add any request modifiers...
                return request;
            };

            const errorHandler = (error) => {
                // Add any error modifiers...
                switch (error.response.status) {
                    case 405:
                    case 401:
                        axios.post('/logout', {
                                '_token': token
                            }
                        ).then(response => {
                            window.location.href = '/login';
                        });
                        break;
                    default:
                        break;
                }

                return Promise.reject({ ...error });
            };

            const successHandler = (response) => {
                // Add any response modifiers...
                return response;
            };

            instance.interceptors.request.use(
                request => requestHandler(request)
            );

            instance.interceptors.response.use(
                response => successHandler(response),
                error => errorHandler(error)
            );

            return instance;
        },
    }
};
