import Vue from 'vue';
import { FETCH_POST, POST_DELETE, POST_EDIT, POST_EDIT_TAGS, POST_EDIT_TOPIC, POST_RESET_STATE } from '../actions.type';
import { SET_POST, SET_TAGS, SET_TOPIC, RESET_STATE } from '../mutations.type';
import request from '../../utils/request';

const initialState = {
    post: {
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
            canonical_link: '',
        },
        tags: [],
        topic: [],
    },
};

export const state = { ...initialState };

export const actions = {
    async [FETCH_POST](context, id) {
        request
            .get('/api/posts/' + id)
            .then((response) => {
                context.commit(SET_POST, response.data.post);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    // eslint-disable-next-line no-unused-vars
    [POST_EDIT]({ context, id, payload }) {
        request
            .post('/api/posts/' + id, payload)
            .then((response) => {
                console.log(response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    [POST_EDIT_TAGS]({ context, tags }) {
        context.commit(SET_TAGS, tags);
    },
    [POST_EDIT_TOPIC]({ context, topic }) {
        context.commit(SET_TOPIC, topic);
    },
    // eslint-disable-next-line no-unused-vars
    [POST_DELETE]({ context, id }) {
        request
            .delete('/api/posts/' + id, id)
            .then((response) => {
                console.log(response.data);
            })
            .catch((errors) => {
                console.log(errors);
            });
    },
    [POST_RESET_STATE]({ commit }) {
        commit(RESET_STATE);
    },
};

export const mutations = {
    [SET_POST](state, post) {
        state.post = post;
    },
    [SET_TAGS](state, tags) {
        state.post.tags = tags;
    },
    [SET_TOPIC](state, topic) {
        state.post.topic = topic;
    },
    [RESET_STATE]() {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    },
};

const getters = {
    post(state) {
        return state.post;
    },
};

export default {
    state,
    actions,
    mutations,
    getters,
};

// export default {
//     namespaced: true,
//     state
// :
// {
//     activePost: {
//     }
// ,
// }
// ,
// getters: {
//     activePost(state)
//     {
//         return state.activePost;
//     }
// ,
// }
// ,
// actions: {
//     setActivePost(context, payload)
//     {
//         context.commit('setActivePost', payload);
//     }
// ,
//
//     updatePostBody(context, body)
//     {
//         context.commit('updatePostBody', body);
//     }
// ,
//
//     saveActivePost(context, payload)
//     {
//         context.commit('saveActivePost', payload);
//     }
// ,
//
//     setPostTags(context, payload)
//     {
//         context.commit('setPostTags', payload);
//     }
// ,
//
//     setPostTopic(context, payload)
//     {
//         context.commit('setPostTopic', payload);
//     }
// ,
//
//     deletePost(context, payload)
//     {
//         context.commit('deletePost', payload);
//     }
// ,
// }
// ,
// mutations: {
//     setActivePost(state, data)
//     {
//         let payload = {};
//
//         payload.id = get(data, 'id', 'create');
//         payload.title = get(data, 'title', '');
//         payload.slug = get(data, 'slug', '');
//         payload.summary = get(data, 'summary', '');
//         payload.body = get(data, 'body', '');
//         payload.published_at = get(data, 'published_at', '');
//         payload.featured_image = get(data, 'featured_image', '');
//         payload.featured_image_caption = get(data, 'featured_image_caption', '');
//
//         payload.meta = {};
//         payload.meta.description = get(data, 'meta.description', '');
//         payload.meta.title = get(data, 'meta.title', '');
//         payload.meta.canonical_link = get(data, 'meta.canonical_link', '');
//
//         payload.topic = get(data, 'topic.0', []);
//         payload.tags = get(data, 'tags', []);
//         payload.errors = [];
//         payload.isSaving = false;
//         payload.hasSuccess = false;
//
//         state.activePost = payload;
//     }
// ,
//
//     updatePostBody(state, data)
//     {
//         state.activePost.body = data;
//     }
// ,
//
//     saveActivePost(state, payload)
//     {
//         let id = this.$app.$route.name === 'posts-create' ? payload.data.id : payload.id;
//
//         this.$app
//             .request()
//             .post('/api/posts/' + id, payload.data)
//             .then((response) => {
//                 if (this.$app.$route.name === 'posts-create') {
//                     this.$app.$router.push({
//                         name: 'posts-edit',
//                         params: { id: response.data.id },
//                     });
//                 }
//
//                 state.activePost.isSaving = false;
//                 state.activePost.hasSuccess = true;
//                 state.activePost.post = response.data;
//             })
//             .catch((error) => {
//                 state.activePost.isSaving = false;
//                 state.activePost.errors = error.response.data.errors;
//             });
//     }
// ,
//
//     setPostTags(state, tags)
//     {
//         state.activePost.tags = tags;
//     }
// ,
//
//     setPostTopic(state, topic)
//     {
//         state.activePost.topic = topic;
//     }
// ,
//
//     deletePost(state, postId)
//     {
//         this.$app
//             .request()
//             .delete('/api/posts/' + postId)
//             .then(() => {
//                 state.activePost = {};
//
//                 this.$app.$router.push({ name: 'posts' });
//             })
//             .catch(() => {
//             });
//     }
// ,
// }
// ,
// }
// ;
