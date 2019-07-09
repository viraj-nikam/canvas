import axios from 'axios';

let baseUrl = '/' + Canvas.path;

const get = () => axios.get(
    baseUrl + '/api/topics',
);

const show = (data) => axios.get(
    baseUrl + '/api/topics/' + data.id,
);

const store = (data) => axios.post(
    baseUrl + '/api/topics/' + data.id,
);

export default {
    get,
    show,
    store,
};
