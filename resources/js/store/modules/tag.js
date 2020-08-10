import request from '../../mixins/request';
import VueRouter from 'vue-router';
import toast from '../../mixins/toast';

const initialState = {
    id: '',
    name: '',
    slug: '',
    errors: [],
};

const state = { ...initialState };

const actions = {
    fetchTag(context, id) {
        request.methods
            .request()
            .get(`/api/tags/${id}`)
            .then(({ data }) => {
                context.commit('SET_TAG', data);
            })
            .catch(() => {
                VueRouter.push({ name: 'tags' });
            });
    },

    updateTag(context, payload) {
        request.methods
            .request()
            .post(`/api/tags/${payload.id}`, {
                name: payload.name,
                slug: payload.slug,
            })
            .then(({ data }) => {
                context.commit('UPDATE_TAG', data);
            })
            .catch((error) => {
                state.errors = error.response.data.errors;
            });
    },

    deleteTag(context, id) {
        request.methods
            .request()
            .delete(`/api/tags/${id}`)
            .then(() => {
                VueRouter.push({ name: 'tags' });
                toast.methods.toast(this.i18n.success);

                // todo: reset the state here?
            })
            .catch(() => {
                // Add any error debugging...
            });
    },
};

const mutations = {
    SET_TAG(state, tag) {
        state.id = tag.id;
        state.name = tag.name || '';
        state.slug = tag.slug || '';
    },

    UPDATE_TAG(state, tag) {
        state.id = tag.id;
        state.name = tag.name;
        state.slug = tag.slug;
    },

    DELETE_TAG(state, tag) {},
};

const getters = {
    //
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
