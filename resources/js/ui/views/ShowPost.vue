<template>
    <section>
        <page-header/>

        <div v-if="isReady" class="mt-5">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 mt-3">
                <h1 class="font-serif">{{ post.title }}</h1>

                <div class="media pt-1 pb-5">
                    <router-link :to="{name: 'show-user', params: { id: post.user.id }}">
                        <img :src="post.user.avatar"
                             class="mr-3 rounded-circle shadow-inner"
                             style="width: 50px"
                             :alt="post.user.name">
                    </router-link>

                    <div class="media-body">
                        <p class="my-0">
                            <span>
                                <router-link :to="{name: 'show-user', params: { id: post.user.id }}" class="text-decoration-none">
                                    {{ post.user.name }}
                                </router-link>
                            </span>
                            <span v-if="post.topic.length">
                                in
                                <router-link :to="{name: 'show-topic', params: { slug: post.topic[0].slug }}" class="text-decoration-none">
                                    {{ post.topic[0].name }}
                                </router-link>
                            </span>
                        </p>
                        <span class="text-secondary">{{ moment(post.published_at).format('MMM D, Y') }} — {{ post.read_time }}</span>
                    </div>
                </div>

                <img v-if="post.featured_image"
                     :src="post.featured_image"
                     class="pt-4 img-fluid w-100"
                     :alt="post.featured_image_caption"
                     :title="post.featured_image_caption">

                <p v-if="post.featured_image && post.featured_image_caption"
                   class="text-muted text-center featured-image-caption"
                   v-html="post.featured_image_caption">
                </p>

                <div class="post-content position-relative align-items-center overflow-y-visible font-serif mt-4">
                    <div v-html="post.body"></div>
                </div>

                <div v-if="post.tags.length" class="mt-5">
                    <router-link
                        v-for="tag in post.tags"
                        :key="tag.id"
                        :to="{ name: 'show-tag', params: { slug: tag.slug } }"
                        class="badge badge-light p-2 my-1 mr-2 text-decoration-none text-uppercase">
                        {{ tag.name }}
                    </router-link>
                </div>

                <div v-if="post.meta.canonical_link" class="post-content position-relative align-items-center overflow-y-visible font-serif">
                    <hr>
                    <p class="text-center font-italic mb-5">
                        This post was originally published on <a :href="post.meta.canonical_link" target="_blank" rel="noopener">{{ parseURL(post.meta.canonical_link).host }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import PageHeader from '../components/PageHeaderComponent';
import NProgress from 'nprogress';
import hljs from 'highlight.js';
import mediumZoom from 'medium-zoom';

export default {
    name: 'show-post',

    components: {
        InfiniteLoading,
        PageHeader,
    },

    data() {
        return {
            uri: this.$route.params.slug,
            page: 1,
            post: null,
            isReady: false,
        };
    },

    async created() {
        await Promise.all([ this.fetchPost() ]);
        this.isReady = true;
        NProgress.done();
    },

    updated() {
        document.querySelectorAll('.embedded_image img').forEach((image) => {
            mediumZoom(image);
        });

        document.querySelectorAll('pre').forEach((block) => {
            hljs.highlightBlock(block);
        });
    },

    methods: {
        fetchPost() {
            return this.request()
                .get(`/api/posts/${this.uri}`)
                .then(({ data }) => {
                    this.post = data;
                    NProgress.inc();
                })
                .catch(() => {
                    NProgress.done();
                });
        },
    },
};
</script>
