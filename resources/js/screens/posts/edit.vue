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
                                    <span v-if="post.published_at <= moment(new Date()).tz(this.timezone).format().slice(0, 19).replace('T', ' ')">{{ trans.nav.context.published }}</span>
                                    <span v-else>{{ trans.nav.context.draft }}</span>
                                </div>

                                <span v-if="form.isSaving" class="pl-2">{{ trans.nav.notify.saving }}</span>
                                <span v-if="form.hasSuccess" class="pl-2 text-success">{{ trans.nav.notify.success }}</span>
                            </li>
                        </ul>

                        <a href="#"
                           class="btn btn-sm btn-outline-primary my-auto ml-auto"
                           @click="saveTag"
                           :aria-label="trans.buttons.general.save">
                            {{ trans.buttons.general.save }}
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
                                <router-link :to="{ name: 'stats-show', params: {id: id } }" class="dropdown-item">
                                    {{ trans.nav.controls.stats }}
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <a href="#"
                                   class="dropdown-item"
                                   @click="showSettingsModal">
                                    {{ trans.nav.controls.settings }}
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
                :topics="topics">
        </settings-modal>

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
    import DeleteModal from '../../components/DeleteModal';
    import VueTextAreaAutosize from 'vue-textarea-autosize';
    import SettingsModal from '../../components/SettingsModal';
    import QuillEditor from '../../components/editor/QuillEditor';
    import ProfileDropdown from '../../components/ProfileDropdown';

    Vue.use(VueTextAreaAutosize);

    export default {
        name: 'posts-edit',

        components: {
            DeleteModal,
            ProfileDropdown,
            QuillEditor,
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
                    errors: [],
                    isSaving: false,
                    hasSuccess: false,
                },
                isReady: false,
                timezone: Canvas.timezone,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.fetchData();
        },

        watch: {},

        methods: {
            fetchData() {
                this.request()
                    .get('/api/posts/' + this.id)
                    .then((response) => {
                        this.post = response.data.post;
                        this.tags = response.data.tags;
                        this.topics = response.data.topics;
                        this.form.id = response.data.post.id;

                        if (this.id !== 'create') {
                            this.form.title = response.data.post.title;
                            this.form.slug = response.data.post.slug;
                            this.form.summary = response.data.post.summary;
                            this.form.body = response.data.post.body;
                            this.form.published_at = response.data.post.published_at;
                            this.form.featured_image = response.data.post.featured_image;
                            this.form.featured_image_caption = response.data.post.featured_image_caption;
                            this.form.meta.meta_description = response.data.post.meta.meta_description;
                            this.form.meta.og_title = response.data.post.meta.og_title;
                            this.form.meta.og_description = response.data.post.meta.og_description;
                            this.form.meta.twitter_title = response.data.post.meta.twitter_title;
                            this.form.meta.twitter_description = response.data.post.meta.twitter_description;
                            this.form.meta.canonical_link = response.data.post.meta.canonical_link;
                        }

                        this.isReady = true;
                    })
                    .catch((error) => {
                        this.$router.push('/posts');
                    });
            },

            saveTag() {
                this.form.errors = [];
                this.form.isSaving = true;
                this.form.hasSuccess = false;

                this.request()
                    .post('/api/posts/' + this.id, this.form)
                    .then((response) => {
                        this.form.isSaving = false;
                        this.form.hasSuccess = true;
                        this.id = response.data.post.id;
                        this.post = response.data.post;
                    })
                    .catch((error) => {
                        this.form.isSaving = false;
                        this.form.errors = error.response.data.errors;
                    })
            },

            deletePost() {
                this.request()
                    .delete('/api/posts/' + this.id)
                    .then((response) => {
                        $(this.$refs.deleteModal.$el).modal('hide');

                        this.$router.push('/posts');
                    })
                    .catch((error) => {
                        console.error(error.response.data.errors);
                    })
            },

            showDeleteModal() {
                $(this.$refs.deleteModal.$el).modal('show');
            },

            showSettingsModal() {
                $(this.$refs.settingsModal.$el).modal('show');
            },
        },
    }
</script>

<style scoped>
    textarea {
        font-size: 42px;
    }
</style>
