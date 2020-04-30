import axios from "axios";

const request = axios.create({
    baseURL: "/" + window.Canvas.path,
    headers: {
        // 'Access-Control-Allow-Origin': '*',
        // 'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        // 'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
            .content,
    },
    timeout: 5000,
});
request.interceptors.request.use(
    (config) => {
        return config;
    },
    (error) => {
        console.log(error);
        Promise.reject(error);
    }
);
request.interceptors.response.use(
    (response) => response,
    (error) => {
        console.log("err" + error);
        // Message({
        //   message: error.message,
        //   type: 'error',
        //   duration: 5000
        // })
        return Promise.reject(error);
    }
);

export default request;
