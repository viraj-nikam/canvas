export default [
    {
        path: '/',
        name: 'posts',
        component: require('./views/AllPosts').default,
    },
    {
        path: '/posts/:slug',
        name: 'show-post',
        component: require('./views/ShowPost').default,
    },
    {
        path: '/tags',
        name: 'tags',
        component: require('./views/AllTags').default,
    },
    {
        path: '/tags/:slug',
        name: 'show-tag',
        component: require('./views/ShowTag').default,
    },
    {
        path: '/topics',
        name: 'topics',
        component: require('./views/AllTopics').default,
    },
    {
        path: '/topics/:slug',
        name: 'show-topic',
        component: require('./views/ShowTopic').default,
    },
    {
        path: '/:id',
        name: 'show-user',
        component: require('./views/ShowUser').default,
    },
    {
        path: '*',
        name: 'catch-all',
        redirect: '/canvas-ui',
    },
]
