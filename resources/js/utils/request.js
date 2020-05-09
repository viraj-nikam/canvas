import axios from 'axios';

const request = axios.create({
    baseURL: '/' + window.Canvas.path,
    headers: {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE',
        'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
    },
    timeout: 5000,
});
request.interceptors.request.use(
    (config) => {
        return config;
    },
    (error) => {
        console.log('err' + error);

        Promise.reject(error);
    }
);
request.interceptors.response.use(
    (response) => response,
    (error) => {
        switch (error.response.status) {
            case 405:
            case 401: {
                let instance = axios.create();

                instance.defaults.baseURL = '/';

                return instance.post('/logout').then(() => {
                    window.location.href = '/login';
                });
            }
            default:
                break;
        }

        return Promise.reject(error);
    }
);

export default request;
