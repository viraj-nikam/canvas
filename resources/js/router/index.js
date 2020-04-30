import Vue from "vue";
import Router from "vue-router";
import AllStats from "../views/AllStats";
import PostStats from "../views/PostStats";
import PostList from "../views/PostList";
import EditPost from "../views/EditPost";
import EditTag from "../views/EditTag";
import TagList from "../views/TagList";
import EditTopic from "../views/EditTopic";
import TopicList from "../views/TopicList";
import EditSettings from "../views/EditSettings";

Vue.use(Router);

export default new Router({
    mode: "history",
    base: window.Canvas.path,
    routes: [
        { path: "/", redirect: "/stats" },
        { path: "/stats", name: "all-stats", component: AllStats },
        { path: "/stats/:id", name: "post-stats", component: PostStats },
        { path: "/posts", name: "posts", component: PostList },
        { path: "/posts/create", name: "create-post", component: EditPost },
        { path: "/posts/:id/edit", name: "edit-post", component: EditPost },
        { path: "/tags", name: "tags", component: TagList },
        { path: "/tags/create", name: "create-tag", component: EditTag },
        { path: "/tags/:id/edit", name: "edit-tag", component: EditTag },
        { path: "/topics", name: "topics", component: TopicList },
        { path: "/topics/create", name: "create-topic", component: EditTopic },
        { path: "/topics/:id/edit", name: "edit-topic", component: EditTopic },
        { path: "/settings", name: "edit-settings", component: EditSettings },
        { path: "*", name: "catch-all", redirect: "/stats" },
    ],
});
