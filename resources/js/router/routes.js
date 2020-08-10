import Vue from 'vue';
import Router from 'vue-router';
import AllStats from '../components/AllStats';
import PostStats from '../components/PostStats';
import PostList from '../components/PostList';
import EditPost from '../components/EditPost';
import EditTag from '../components/EditTag';
import TagList from '../components/TagList';
import EditTopic from '../components/EditTopic';
import TopicList from '../components/TopicList';
import EditSettings from '../components/EditSettings';
import EditUser from '../components/EditUser';
import UserList from '../components/UserList';
import { store } from '../store';

Vue.use(Router);

let auth = store.state.auth;

export default [
    {
        path: '/',
        name: 'home',
        redirect: '/stats',
    },
    {
        path: '/stats',
        name: 'stats',
        component: AllStats,
    },
    {
        path: '/stats/:id',
        name: 'post-stats',
        component: PostStats,
    },
    {
        path: '/posts',
        name: 'posts',
        component: PostList,
    },
    {
        path: '/posts/create',
        name: 'create-post',
        component: EditPost,
    },
    {
        path: '/posts/:id/edit',
        name: 'edit-post',
        component: EditPost,
    },
    {
        path: '/tags',
        name: 'tags',
        component: TagList,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/tags/create',
        name: 'create-tag',
        component: EditTag,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/tags/:id/edit',
        name: 'edit-tag',
        component: EditTag,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/topics',
        name: 'topics',
        component: TopicList,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/topics/create',
        name: 'create-topic',
        component: EditTopic,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/topics/:id/edit',
        name: 'edit-topic',
        component: EditTopic,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/settings',
        name: 'edit-settings',
        component: EditSettings,
    },
    {
        path: '/users',
        name: 'users',
        component: UserList,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '/users/:id/edit',
        name: 'edit-user',
        component: EditUser,
        beforeEnter: (to, from, next) => {
            if (auth.admin === 1 || auth.id === to.params.id) {
                next();
            } else {
                next({ name: 'home' });
            }
        },
    },
    {
        path: '*',
        name: 'catch-all',
        redirect: '/stats',
    },
];
