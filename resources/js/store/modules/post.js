import request from '../../mixins/request';

const initialState = {
    id: '',
    title: '',
    slug: '',
    summary: '',
    body: '',
    published_at: '',
    featured_image: '',
    featured_image_caption: '',
    meta: {
        description: '',
        title: '',
        canonicalLink: '',
    },
    tags: [],
    topic: [],
    isSaving: false,
    isSaved: false,
    errors: [],
};

const state = { ...initialState };

const actions = {
    fetchPost(context, id) {
        request.methods
            .request()
            .get(`/api/posts/${id}`)
            .then(({ data }) => {
                context.commit('SET_POST', data);
            }).catch(() => {
                console.log('Push to /posts route...');
        });
    },
};

const mutations = {
    SET_POST(state, data) {
        state = data;
    }
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
