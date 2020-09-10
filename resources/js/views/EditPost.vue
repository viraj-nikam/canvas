<template>
    <section>
        <page-header>
            <template slot="status">
                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <div class="border-left pl-3">
                            <div v-if="!isSaving && !isSaved">
                                <span v-if="isPublished(post.published_at)">{{ trans.published }}</span>
                                <span v-if="isDraft(post.published_at)">{{ trans.draft }}</span>
                            </div>
                            <span v-if="isSaving">{{ trans.saving }}</span>
                            <span v-if="isSaved" class="text-success">{{ trans.saved }}</span>
                        </div>
                    </li>
                </ul>
            </template>

            <template slot="options">
                <div class="dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link pr-0"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="25"
                            class="icon-dots-horizontal"
                        >
                            <path
                                class="fill-light-gray"
                                fill-rule="evenodd"
                                d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
                            />
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link
                            v-if="isPublished(post.publishedAt)"
                            :to="{ name: 'post-stats', params: { id: uri } }"
                            class="dropdown-item"
                        >
                            {{ trans.view_stats }}
                        </router-link>
                        <div v-if="isPublished(post.publishedAt)" class="dropdown-divider"/>
                        <a
                            v-if="isDraft(post.publishedAt) && (isAdmin || isEditor)"
                            href="#"
                            class="dropdown-item"
                            @click="showPublishModal"
                        > {{ trans.publish }} </a>
                        <a href="#" class="dropdown-item" @click="showSettingsModal"> {{ trans.general_settings }} </a>
                        <a href="#" class="dropdown-item" @click="showFeaturedImageModal"> {{ trans.featured_image }} </a>
                        <a href="#" class="dropdown-item" @click="showSeoModal"> {{ trans.seo_settings }} </a> <a
                        v-if="isPublished(post.publishedAt)"
                        href="#"
                        class="dropdown-item"
                        @click.prevent="convertToDraft"
                    > {{ trans.convert_to_draft }} </a>
                        <a v-if="!creatingPost" href="#" class="dropdown-item text-danger" @click="showDeleteModal"> {{ trans.delete }} </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="form-group my-3">
                    <textarea-autosize
                        v-model="post.title"
                        :placeholder="trans.title"
                        style="font-size: 42px"
                        class="w-100 form-control-lg border-0 font-serif bg-transparent px-0"
                        rows="1"
                    />
                </div>

                <div class="form-group my-2">
                    <quill-editor
                        :post="post"
                        :key="post.id"
                        @update="savePost"
                    />
                </div>
            </div>
        </main>

        <section v-if="isReady">
            <publish-modal
                :post="post"
                ref="publishModal"
                @update="savePost"
            />
            <settings-modal
                :post="post"
                :tags="tags"
                :topics="topics"
                ref="settingsModal"
                @update="savePost"
            />
            <featured-image-modal
                :post="post"
                ref="featuredImageModal"
                @update="savePost"
            />
            <seo-modal
                v-if="post.meta"
                :post="post"
                ref="seoModal"
                @update="savePost"
            />
            <delete-modal
                ref="deleteModal"
                :header="trans.delete"
                :message="trans.deleted_posts_are_gone_forever"
                @delete="deletePost"
            />
        </section>
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import $ from 'jquery';
import DeleteModal from '../components/modals/DeleteModal';
import FeaturedImageModal from '../components/modals/FeaturedImageModal';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import PublishModal from '../components/modals/PublishModal';
import QuillEditor from '../components/editor/QuillEditor';
import SeoModal from '../components/modals/SeoModal';
import SettingsModal from '../components/modals/SettingsModal';
import Vue from 'vue';
import VueTextAreaAutosize from 'vue-textarea-autosize';
import status from '../mixins/status';
import isEmpty from "lodash/isEmpty";

Vue.use(VueTextAreaAutosize);

export default {
    name: 'edit-post',

    components: {
        PublishModal,
        FeaturedImageModal,
        DeleteModal,
        QuillEditor,
        PageHeader,
        SeoModal,
        SettingsModal,
    },

    mixins: [ status ],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            post: {},
            tags: [],
            topics: [],
            errors: [],
            isSaving: false,
            isSaved: false,
            isReady: false,
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
            isAdmin: 'settings/isAdmin',
            isEditor: 'settings/isEditor',
        }),

        creatingPost() {
            return this.$route.name === 'create-post';
        },
    },

    watch: {
        async $route(to) {
            if (this.uri === 'create' && to.params.id === this.post.id) {
                this.uri = to.params.id;
            }

            if (this.uri !== to.params.id) {
                this.isReady = false;
                this.uri = to.params.id;
                await Promise.all([this.fetchPost()]);
                this.isReady = true;
                NProgress.done();
            }
        },
    },

    async created() {
        await Promise.all([ this.fetchPost() ]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchPost() {
            this.request()
                .get(`/api/posts/${ this.uri }`)
                .then(({ data }) => {
                    this.post = data.post;
                    this.tags = data.tags;
                    this.topics = data.topics;
                })
                .catch(() => {
                    this.$router.push({ name: 'posts' });
                });

            NProgress.inc();
        },

        savePost() {
            this.errors = [];
            this.isSaving = true;
            this.isSaved = false;

            // this.$store.dispatch('saveActivePost', {
            //     data: this.post,
            //     id: this.id,
            // });

            setTimeout(() => {
                this.isSaved = false;
                this.isSaving = false;
            }, 3000);
        },

        convertToDraft() {
            this.post.published_at = '';
            this.save();
        },

        async deletePost() {
            await this.request()
                .delete(`/api/posts/${this.post.id}`)
                .then(() => {
                    this.$store.dispatch('search/buildIndex', true);
                    this.$toasted.show(this.trans.success, {
                        className: 'bg-success',
                    });
                });

            $(this.$refs.deleteModal.$el).modal('hide');

            await this.$router.push({ name: 'posts' });
        },

        showPublishModal() {
            $(this.$refs.publishModal.$el).modal('show');
        },

        showSettingsModal() {
            $(this.$refs.settingsModal.$el).modal('show');
        },

        showFeaturedImageModal() {
            $(this.$refs.featuredImageModal.$el).modal('show');
        },

        showSeoModal() {
            $(this.$refs.seoModal.$el).modal('show');
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
        },
    },
};
</script>
