import axios from 'axios';

let baseUrl = '/' + Canvas.path;

const get = () => axios.get(
    baseUrl + '/api/stats',
);

const show = (data) => axios.get(
    baseUrl + '/api/stats/' + data.id,
);

export default {
    get,
    show,
};
