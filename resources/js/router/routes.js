import AllStats from '../views/AllStats';
import EditPost from '../views/EditPost';
import EditSettings from '../views/EditSettings';
import EditTag from '../views/EditTag';
import EditTopic from '../views/EditTopic';
import EditUser from '../views/EditUser';
import PostList from '../views/PostList';
import NoteList from '../views/NoteList';
import PostStats from '../views/PostStats';
import EditNote from '../views/EditNote';
import TagList from '../views/TagList';
import TopicList from '../views/TopicList';
import UserList from '../views/UserList';
import settings from '../store/modules/settings';

let isAdmin = settings.state.user.role === 3;

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
        meta: { title: 'Stats' },
    },
    {
        path: '/posts',
        name: 'posts',
        component: PostList,
        meta: { title: 'Posts' },
    },
    {
        path: '/notes',
        name: 'notes',
        component: NoteList,
        meta: { title: 'Notes' },
    },
    {
        path: '/posts/create',
        name: 'create-post',
        component: EditPost,
        meta: { title: 'Post' },
    },
    {
        path: '/notes/create',
        name: 'create-note',
        component: EditNote,
        meta: { title: 'Note' },
    },
    {
        path: '/posts/:id/stats',
        name: 'post-stats',
        component: PostStats,
        meta: { title: 'Post Stats' },
    },
    {
        path: '/posts/:id/edit',
        name: 'edit-post',
        component: EditPost,
        meta: { title: 'Post' },
    },
    {
        path: '/notes/:id/edit',
        name: 'edit-note',
        component: EditNote,
        meta: { title: 'Note' },
    },
    {
        path: '/tags',
        name: 'tags',
        component: TagList,
        meta: { title: 'Tags' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/tags/create',
        name: 'create-tag',
        component: EditTag,
        meta: { title: 'Tag' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/tags/:id/edit',
        name: 'edit-tag',
        component: EditTag,
        meta: { title: 'Tag' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/topics',
        name: 'topics',
        component: TopicList,
        meta: { title: 'Topics' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/topics/create',
        name: 'create-topic',
        component: EditTopic,
        meta: { title: 'Topic' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/topics/:id/edit',
        name: 'edit-topic',
        component: EditTopic,
        meta: { title: 'Topic' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/settings',
        name: 'edit-settings',
        component: EditSettings,
        meta: { title: 'Settings' },
    },
    {
        path: '/users',
        name: 'users',
        component: UserList,
        meta: { title: 'Users' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/users/create',
        name: 'create-user',
        component: EditUser,
        meta: { title: 'User' },
        beforeEnter: (to, from, next) => {
            isAdmin ? next() : next({ name: 'home' });
        },
    },
    {
        path: '/users/:id/edit',
        name: 'edit-user',
        component: EditUser,
        meta: { title: 'User' },
        beforeEnter: (to, from, next) => {
            if (isAdmin || settings.state.user.id == to.params.id) {
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
