import request from "../../mixins/request";

const initialState = {
    i18n: JSON.parse(window.Canvas.translations)['app'],
    languageCodes: window.Canvas.languageCodes,
    maxUpload: window.Canvas.maxUpload,
    path: window.Canvas.path,
    timezone: window.Canvas.timezone,
    unsplash: window.Canvas.unsplash,
};

const state = { ...initialState };

const actions = {
    updateI18n(context, code) {
        request.methods.request()
            .get('/api/locale/' + code)
            .then((response) => {
                context.commit('UPDATE_I18N', response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    }
};

const mutations = {
    UPDATE_I18N(state, payload) {
        state.i18n = payload.app
    }
};

const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
