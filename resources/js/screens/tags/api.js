import axios from 'axios';

let baseUrl = '/' + Canvas.path;

const create = (data) => axios.post(
    baseUrl + '/api/tags/' + data.id,
);

const fetch = (data) => axios.get(
    baseUrl + '/api/tags/' + data.id,
);

export default {
    create,
    fetch,
};
