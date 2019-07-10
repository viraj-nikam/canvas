import axios from 'axios';

let baseUrl = '/' + Canvas.path;

const get = () => axios.get(
    baseUrl + '/api/tags',
);

const show = (data) => axios.get(
    baseUrl + '/api/tags/' + data.id,
);

const store = (data) => axios.post(
    baseUrl + '/api/tags/' + data.id, data
);

export default {
    get,
    show,
    store,
};
