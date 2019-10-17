<template>
    <div>
        <page-header>
            <template slot="status">
                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <div class="d-inline-block">
                            <span v-if="isDraft">
                                {{ trans.nav.context.published }}
                            </span>
                            <span v-else>
                                {{ trans.nav.context.draft }}
                            </span>
                        </div>

                        <span v-if="storeState.form.isSaving" class="pl-2">{{ trans.nav.notify.saving }}</span>
                        <span v-if="storeState.form.hasSuccess" class="pl-2 text-success">{{ trans.nav.notify.success }}</span>
                    </li>
                </ul>
            </template>

            <template slot="action">
                <a v-if="isDraft" href="#" class="btn btn-sm btn-outline-success font-weight-bold" @click="save">
                    {{ trans.buttons.general.save }}
                </a>

                <a v-else href="#" class="btn btn-sm btn-outline-success font-weight-bold font-weight-bolder" @click="showPublishModal">
                    {{ trans.buttons.posts.ready }}
                </a>
            </template>

            <template slot="menu">
                <div class="dropdown">
                    <a id="navbarDropdown" class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" class="icon-dots-horizontal">
                            <path class="primary" fill-rule="evenodd" d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link :to="{name: 'stats-show', params: { id: id }}" v-if="isDraft" class="dropdown-item">
                            {{ trans.nav.controls.stats }}
                        </router-link>
                        <div class="dropdown-divider" v-if="isDraft"></div>
                        <a href="#" class="dropdown-item" @click="showSettingsModal">
                            {{ trans.nav.controls.settings }}
                        </a>
                        <a href="#" class="dropdown-item" @click="showFeaturedImageModal">
                            {{ trans.nav.controls.image }}
                        </a>
                        <a href="#" class="dropdown-item" @click="showSeoModal">
                            {{ trans.nav.controls.seo }}
                        </a>
                        <a v-if="isDraft" href="#" class="dropdown-item" @click.prevent="convertToDraft">
                            {{ trans.buttons.general.draft }}
                        </a>
                        <a v-if="id !== 'create'" href="#" class="dropdown-item text-danger" @click="showDeleteModal">
                            {{ trans.buttons.general.delete }}
                        </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8" v-if="isReady">
                        <div class="form-group row my-3">
                            <div class="col-lg-12">
                                <textarea-autosize
                                    :placeholder="trans.posts.forms.editor.title"
                                    class="form-control-lg form-control border-0 pl-0 font-serif"
                                    @input.native="update"
                                    rows="1"
                                    v-model="storeState.form.title"
                                />
                            </div>
                        </div>

                        <quill-editor></quill-editor>
                    </div>
                </div>
            </div>
        </main>

        <publish-modal
            v-if="isReady"
            ref="publishModal"
        />

        <settings-modal
            v-if="isReady"
            ref="settingsModal"
            :post="post"
            :tags="tags"
            :topics="topics"
        />

        <featured-image-modal
            v-if="isReady"
            ref="featuredImageModal"
        />

        <seo-modal
            v-if="isReady"
            ref="seoModal"
        />

        <delete-modal
            v-if="isReady"
            ref="deleteModal"
            @delete="deletePost"
            :header="trans.posts.delete.header"
            :message="trans.posts.delete.warning"
        />
    </div>
</template>

<script>
    import Vue from "vue";
    import $ from "jquery";
    import moment from "moment";
    import {store} from "./store";
    import SeoModal from "../../components/SeoModal";
    import PageHeader from "../../components/PageHeader";
    import DeleteModal from "../../components/DeleteModal";
    import VueTextAreaAutosize from "vue-textarea-autosize";
    import PublishModal from "../../components/PublishModal";
    import SettingsModal from "../../components/SettingsModal";
    import QuillEditor from "../../components/editor/QuillEditor";
    import FeaturedImageModal from "../../components/FeaturedImageModal";

    Vue.use(VueTextAreaAutosize);

    export default {
        name: "posts-edit",

        components: {
            PublishModal,
            FeaturedImageModal,
            DeleteModal,
            QuillEditor,
            PageHeader,
            SeoModal,
            SettingsModal
        },

        data() {
            return {
                post: null,
                tags: [],
                topics: [],
                id: this.$route.params.id || "create",
                storeState: store.state,
                isReady: false,
                timezone: Canvas.timezone,
                trans: JSON.parse(Canvas.lang)
            };
        },

        created() {
            this.fetchData();
        },

        beforeRouteLeave(to, from, next) {
            // Reset the form status to avoid it flashing on the next screen load
            this.storeState.form.isSaving = false;
            this.storeState.form.hasSuccess = false;

            next();
        },

        computed: {
            isDraft() {
                return this.post && this.post.published_at <= moment(new Date()).tz(this.timezone).format().slice(0, 19).replace("T", " ");
            }
        },

        methods: {
            fetchData() {
                this.request()
                    .get("/api/posts/" + this.id)
                    .then(response => {
                        store.hydrateForm(response.data.post);

                        this.post = response.data.post;
                        this.tags = response.data.tags;
                        this.topics = response.data.topics;
                        this.isReady = true;
                    })
                    .catch(error => {
                        this.$router.push({name: "posts"});
                    });
            },

            save() {
                this.storeState.form.errors = [];
                this.storeState.form.isSaving = true;
                this.storeState.form.hasSuccess = false;

                this.request()
                    .post("/api/posts/" + this.id, this.storeState.form)
                    .then(response => {
                        if (this.id === "create") {
                            this.$router.push({
                                name: "posts-edit",
                                params: {id: response.data.id}
                            });
                        }

                        this.storeState.form.isSaving = false;
                        this.storeState.form.hasSuccess = true;
                        this.id = response.data.id;
                        this.post = response.data;
                    })
                    .catch(error => {
                        this.storeState.form.isSaving = false;
                        this.storeState.form.errors = error.response.data.errors;
                    });
            },

            update: _.debounce(function (e) {
                this.save();
            }, 900),

            convertToDraft() {
                this.storeState.form.published_at = "";
                this.save();
            },

            deletePost() {
                this.request()
                    .delete("/api/posts/" + this.id)
                    .then(response => {
                        $(this.$refs.deleteModal.$el).modal("hide");

                        this.$router.push({name: "posts"});
                    })
                    .catch(error => {
                        // Add any error debugging...
                    });
            },

            showPublishModal() {
                $(this.$refs.publishModal.$el).modal("show");
            },

            showSettingsModal() {
                $(this.$refs.settingsModal.$el).modal("show");
            },

            showFeaturedImageModal() {
                $(this.$refs.featuredImageModal.$el).modal("show");
            },

            showSeoModal() {
                $(this.$refs.seoModal.$el).modal("show");
            },

            showDeleteModal() {
                $(this.$refs.deleteModal.$el).modal("show");
            }
        }
    };
</script>

<style scoped>
    textarea {
        font-size: 42px;
    }
</style>
