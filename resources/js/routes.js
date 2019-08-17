export default [
    { path: '/', redirect: '/stats' },

    {
        path: '/stats',
        name: 'stats',
        component: require('./screens/stats/index').default,
    },

    {
        path: '/stats/:id',
        name: 'stats-show',
        component: require('./screens/stats/show').default,
    },

    {
        path: '/posts',
        name: 'posts',
        component: require('./screens/posts/index').default,
    },

    {
        path: '/posts/create',
        name: 'posts-create',
        component: require('./screens/posts/edit').default,
    },

    {
        path: '/posts/:id/edit',
        name: 'posts-edit',
        component: require('./screens/posts/edit').default,
    },

    {
        path: '/tags',
        name: 'tags',
        component: require('./screens/tags/index').default,
    },

    {
        path: '/tags/create',
        name: 'tags-create',
        component: require('./screens/tags/edit').default,
    },

    {
        path: '/tags/:id/edit',
        name: 'tags-edit',
        component: require('./screens/tags/edit').default,
    },

    {
        path: '/topics',
        name: 'topics',
        component: require('./screens/topics/index').default,
    },

    {
        path: '/topics/create',
        name: 'topics-create',
        component: require('./screens/topics/edit').default,
    },

    {
        path: '/topics/:id/edit',
        name: 'topics-edit',
        component: require('./screens/topics/edit').default,
    },

    {
        path: '*',
        name: 'catch-all',
        redirect: '/stats'
    },
];
