<template>
    <section>
        <page-header/>

        <div v-if="isReady" class="mt-5">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 mt-3">
                <h1 class="font-serif">Canvas</h1>
                <p class="lead text-secondary">A Laravel Publishing Platform</p>

                <main role="main" class="mt-5">
                    <div>
                        <h4 class="my-4 border-bottom mt-5 pb-2">
                            <span class="border-bottom border-dark pb-2">Tags</span>
                        </h4>

                        <div v-if="tags.length > 0">
                            <div class="row row-cols-1 row-cols-md-3 row-cols-sm-2">
                                <div v-for="tag in tags">
                                    <router-link :to="{ name: 'show-tag', params: { slug: tag.slug } }" class="text-decoration-none">
                                        <div class="col mb-4">
                                            <div class="card mb-4 shadow-sm">
                                                <div class="card-body">
                                                    <p class="card-text">{{ tag.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</template>

<script>
import PageHeader from '../components/PageHeaderComponent';
import NProgress from 'nprogress';

export default {
    name: 'all-tags',

    components: {
        PageHeader,
    },

    data() {
        return {
            tags: [],
            isReady: false,
        };
    },

    async created() {
        await Promise.all([ this.fetchTags() ]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchTags() {
            return this.request()
                .get('/api/tags')
                .then(({ data }) => {
                    this.tags = data;
                    NProgress.inc();
                })
                .catch(() => {
                    NProgress.done();
                });
        },
    },
};
</script>
