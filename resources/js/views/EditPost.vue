<template>
    <section>
        <page-header>
            <template slot="status">
                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <div class="border-left pl-3">
                            <span v-if="isPublished(activePost.published_at)">{{ trans.published }}</span>
                            <span v-if="isDraft(activePost.published_at)">{{ trans.draft }}</span>
                        </div>
                    </li>
                </ul>
            </template>

            <!--            <template slot="action">-->
            <!--                <a-->
            <!--                    v-if="isDraft(post.published_at)"-->
            <!--                    href="#"-->
            <!--                    class="btn btn-sm btn-outline-success font-weight-bold my-auto"-->
            <!--                    @click="showPublishModal"-->
            <!--                >-->
            <!--                    <span class="d-block d-lg-none">{{ trans.publish }}</span>-->
            <!--                    <span class="d-none d-lg-block">{{ trans.ready_to_publish }}</span>-->
            <!--                </a>-->

            <!--                <a v-else href="#" class="btn btn-sm btn-outline-success font-weight-bold my-auto" @click="save">-->
            <!--                    {{ trans.save }}-->
            <!--                </a>-->
            <!--            </template>-->

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
                            v-if="isPublished(activePost.published_at)"
                            :to="{ name: 'post-stats', params: { id: uri } }"
                            class="dropdown-item"
                        >
                            {{ trans.view_stats }}
                        </router-link>
                        <div v-if="isPublished(activePost.published_at)" class="dropdown-divider" />
                        <a href="#" class="dropdown-item" @click="showSettingsModal"> {{ trans.general_settings }} </a>
                        <a href="#" class="dropdown-item" @click="showFeaturedImageModal">
                            {{ trans.featured_image }}
                        </a>
                        <a href="#" class="dropdown-item" @click="showSeoModal"> {{ trans.seo_settings }} </a>
                        <a
                            v-if="isPublished(activePost.published_at)"
                            href="#"
                            class="dropdown-item"
                            @click.prevent="convertToDraft"
                        >
                            {{ trans.convert_to_draft }}
                        </a>
                        <a v-if="!creatingPost" href="#" class="dropdown-item text-danger" @click="showDeleteModal">
                            {{ trans.delete }}
                        </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="form-group my-3">
                    <textarea-autosize
                        v-model="title"
                        :placeholder="trans.title"
                        style="font-size: 42px"
                        class="w-100 form-control-lg border-0 font-serif bg-transparent px-0"
                        rows="1"
                        @input.native="update"
                    />
                </div>

                <div class="form-group my-4">
                    <!--<quill-editor/>-->
                </div>
            </div>
        </main>

        <publish-modal ref="publishModal" v-if="isReady" />
        <settings-modal ref="settingsModal" v-if="isReady" />
        <featured-image-modal ref="featuredImageModal" v-if="isReady" />
        <seo-modal ref="seoModal" v-if="isReady" />
        <delete-modal
            ref="deleteModal"
            v-if="isReady"
            :header="trans.delete"
            :message="trans.deleted_posts_are_gone_forever"
            @delete="deletePost"
        />
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
import debounce from 'lodash/debounce';
import status from '../mixins/status';

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

    mixins: [status],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            title: '',
            tags: [],
            topics: [],
            isReady: false,
        };
    },

    computed: {
        ...mapGetters({
            activePost: 'post/activePost',
            trans: 'settings/trans',
        }),

        creatingPost() {
            return this.$route.name === 'create-post';
        },
    },

    created() {
        this.fetchPost();
        this.isReady = true;
        NProgress.done();
    },

    // beforeRouteEnter(to, from, next) {
    // next((vm) => {
    //     vm.request()
    //         .get(`/api/posts/${vm.id}`)
    //         .then((response) => {
    //             vm.$store.dispatch('setActivePost', response.data.post);
    //
    //             vm.post = vm.$store.getters.activePost;
    //             vm.tags = response.data.tags;
    //             vm.topics = response.data.topics;
    //             vm.isReady = true;
    //
    //             NProgress.done();
    //         })
    //         .catch(() => {
    //             vm.$router.push({ name: 'posts' });
    //         });
    // });
    // },

    // beforeRouteLeave(to, from, next) {
    //     // Reset the form status to avoid it flashing on the next screen load
    //     this.post.isSaving = false;
    //     this.post.hasSuccess = false;
    //
    //     next();
    // },

    methods: {
        fetchPost() {
            this.$store.dispatch('post/fetchPost', this.uri);
            NProgress.inc();
        },

        savePost() {
            // this.post.errors = [];
            // this.post.isSaving = true;
            // this.post.hasSuccess = false;
            //
            // if (this.id === 'create') {
            //     this.id = this.post.id;
            // }
            //
            // this.$store.dispatch('saveActivePost', {
            //     data: this.post,
            //     id: this.id,
            // });
            //
            // setTimeout(() => {
            //     this.post.hasSuccess = false;
            //     this.post.isSaving = false;
            // }, 3000);
        },

        update: debounce(function () {
            // this.save();
        }, 3000),

        convertToDraft() {
            // this.post.published_at = '';
            // this.save();
        },

        deletePost() {
            this.$store.dispatch('post/deletePost', this.activePost.id);
            $(this.$refs.deleteModal.$el).modal('hide');
            this.$router.push({ name: 'posts' });
            this.$toasted.show(this.trans.success, {
                className: 'bg-success',
            });
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
