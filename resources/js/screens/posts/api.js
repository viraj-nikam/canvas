import axios from 'axios';

let baseUrl = '/' + Canvas.path;

const get = () => axios.get(
    baseUrl + '/api/posts',
);

const show = (data) => axios.get(
    baseUrl + '/api/posts/' + data.id,
);

const store = (data) => axios.post(
    baseUrl + '/api/posts/' + data.id,
);

export default {
    get,
    show,
    store,
};
