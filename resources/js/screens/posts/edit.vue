<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <ul class="navbar-nav mr-auto flex-row float-right">
                            <li class="text-muted font-weight-bold">
                                <div v-if="isReady" class="d-inline-block">
                                    <span>{{ getContextualState() }}</span>
                                </div>

                                <span v-if="form.isSaving" class="pl-2">{{ trans.nav.notify.saving }}</span>
                                <span v-if="form.hasSuccess" class="pl-2 text-success">{{ trans.nav.notify.success }}</span>
                            </li>
                        </ul>

                        <a v-if="isPublished"
                           href="#"
                           class="btn btn-sm btn-outline-primary my-auto ml-auto"
                           @click="save">
                            {{ trans.buttons.posts.save }}
                        </a>

                        <a v-else
                           href="#"
                           class="btn btn-sm btn-outline-primary my-auto ml-auto"
                           @click="showPublishModal">
                            {{ trans.buttons.posts.ready }}
                        </a>

                        <div class="dropdown">
                            <a id="navbarDropdown"
                               class="nav-link text-secondary pr-0"
                               href="#"
                               role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-sliders-h fa-fw fa-rotate-270"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <router-link :to="{ name: 'stats-show', params: {id: id } }" v-if="isPublished" class="dropdown-item">
                                    {{ trans.nav.controls.stats }}
                                </router-link>
                                <div class="dropdown-divider" v-if="isPublished"></div>
                                <a href="#"
                                   class="dropdown-item"
                                   @click="showSettingsModal">
                                    {{ trans.nav.controls.settings }}
                                </a>
                                <a href="#"
                                   class="dropdown-item"
                                   @click="showFeaturedImageModal">
                                    {{ trans.nav.controls.image }}
                                </a>
                                <a href="#"
                                   class="dropdown-item"
                                   @click="showSeoModal">
                                    {{ trans.nav.controls.seo }}
                                </a>
                                <a v-if="id !== 'create'"
                                   href="#"
                                   class="dropdown-item text-danger"
                                   @click="showDeleteModal">
                                    {{ trans.buttons.general.delete }}
                                </a>
                            </div>
                        </div>

                        <profile-dropdown></profile-dropdown>
                    </nav>
                </div>
            </div>
        </div>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8" v-if="isReady">
                        <div class="form-group row my-3">
                            <div class="col-lg-12">
                                <textarea-autosize
                                    :placeholder="trans.posts.forms.editor.title"
                                    class="form-control-lg form-control border-0 pl-0 serif"
                                    rows="1"
                                    @change.native="update"
                                    v-model="form.title">
                                </textarea-autosize>
                            </div>
                        </div>

                        <quill-editor :value="form.body"></quill-editor>
                    </div>
                </div>
            </div>
        </main>

        <settings-modal
            v-if="isReady"
            ref="settingsModal"
            :input="form"
            :post="post"
            :tags="tags"
            :topics="topics"
            @updating="save">
        </settings-modal>

        <featured-image-modal
            v-if="isReady"
            ref="featuredImageModal"
            :input="form"
            @updating="save">
        </featured-image-modal>

        <seo-modal
            v-if="isReady"
            ref="seoModal"
            :input="form"
            @updating="save">
        </seo-modal>

        <delete-modal
            ref="deleteModal"
            @delete="deletePost"
            :header="trans.posts.delete.header"
            :message="trans.posts.delete.warning">
        </delete-modal>
    </div>
</template>

<script>
    import Vue from 'vue';
    import $ from 'jquery';
    import moment from 'moment';
    import {Bus} from '../../bus';
    import SeoModal from "../../components/SeoModal";
    import DeleteModal from '../../components/DeleteModal';
    import VueTextAreaAutosize from 'vue-textarea-autosize';
    import SettingsModal from '../../components/SettingsModal';
    import QuillEditor from '../../components/editor/QuillEditor';
    import ProfileDropdown from '../../components/ProfileDropdown';
    import FeaturedImageModal from "../../components/FeaturedImageModal";

    Vue.use(VueTextAreaAutosize);

    export default {
        name: 'posts-edit',

        components: {
            FeaturedImageModal,
            DeleteModal,
            ProfileDropdown,
            QuillEditor,
            SeoModal,
            SettingsModal
        },

        data() {
            return {
                post: null,
                tags: [],
                topics: [],
                id: this.$route.params.id || 'create',
                form: {
                    id: '',
                    title: '',
                    slug: '',
                    summary: '',
                    body: '',
                    published_at: '',
                    featured_image: '',
                    featured_image_caption: '',
                    meta: {
                        meta_description: '',
                        og_title: '',
                        og_description: '',
                        twitter_title: '',
                        twitter_description: '',
                        canonical_link: '',
                    },
                    topic: [],
                    tags: [],
                    errors: [],
                    isSaving: false,
                    hasSuccess: false,
                },
                isReady: false,
                timezone: Canvas.timezone,
                trans: JSON.parse(Canvas.lang),
            }
        },

        created() {
            Bus.$on('updating', data => {
                this.fillFormData(data);
                this.save();
            });
        },

        mounted() {
            this.fetchData();
        },

        computed: {
            isPublished() {
                return !!(this.post && this.post.published_at <= moment(new Date()).tz(this.timezone).format().slice(0, 19).replace('T', ' '));
            },
        },

        methods: {
            fetchData() {
                this.request()
                    .get('/api/posts/' + this.id)
                    .then((response) => {
                        this.post = response.data.post;
                        this.tags = response.data.tags;
                        this.topics = response.data.topics;
                        this.form.id = response.data.post.id;
                        this.form.slug = response.data.post.slug;

                        if (this.id !== 'create') {
                            this.fillFormData(response.data.post);
                        }

                        this.isReady = true;
                    })
                    .catch((error) => {
                        this.$router.push({name: 'posts'});
                    });
            },

            fillFormData(data) {
                // todo: refactor these to be less ugly?

                this.form.title = data && data.title || this.form.title;
                this.form.slug = data && data.slug || this.form.slug;
                this.form.summary = data && data.summary || this.form.summary;
                this.form.body = data && data.body || this.form.body;
                this.form.published_at = data && data.published_at || this.form.published_at;
                this.form.featured_image = data && data.featured_image || this.form.featured_image;
                this.form.featured_image_caption = data && data.featured_image_caption || this.form.featured_image_caption;
                this.form.meta.meta_description = data && data.meta && data.meta.meta_description || this.form.meta.meta_description;
                this.form.meta.og_title = data && data.meta && data.meta.og_title || this.form.meta.og_title;
                this.form.meta.og_description = data && data.meta && data.meta.og_description || this.form.meta.og_description;
                this.form.meta.twitter_title = data && data.meta && data.meta.twitter_title || this.form.meta.twitter_title;
                this.form.meta.twitter_description = data && data.meta && data.meta.twitter_description || this.form.meta.twitter_description;
                this.form.meta.canonical_link = data && data.meta && data.meta.canonical_link || this.form.meta.canonical_link;
                this.form.topic = data && data.topic || this.form.topic;
                this.form.tags = data && data.tags || this.form.tags;
            },

            save() {
                this.form.errors = [];
                this.form.hasSuccess = false;
                this.form.isSaving = true;

                this.request()
                    .post('/api/posts/' + this.id, this.form)
                    .then((response) => {
                        this.form.isSaving = false;
                        this.form.hasSuccess = true;
                        this.id = response.data.id;
                        this.post = response.data;

                        this.$router.push({name: 'posts-edit', params: {id: response.data.id}});
                    })
                    .catch((error) => {
                        this.form.isSaving = false;
                        this.form.errors = error.response.data.errors;
                    });
            },

            update: _.debounce(function (e) {
                this.save();
            }, 700),

            deletePost() {
                this.request()
                    .delete('/api/posts/' + this.id)
                    .then((response) => {
                        $(this.$refs.deleteModal.$el).modal('hide');

                        this.$router.push({name: 'posts'});
                    })
                    .catch((error) => {
                        console.error(error.response.data.errors);
                    });
            },

            getContextualState() {
                return this.isPublished ? this.trans.nav.context.published : this.trans.nav.context.draft;
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
    }
</script>

<style scoped>
    textarea {
        font-size: 42px;
    }
</style>
