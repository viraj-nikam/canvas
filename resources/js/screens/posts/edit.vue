<template>
    <div v-cloak>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <ul class="navbar-nav mr-auto flex-row float-right">
                            <li class="text-muted font-weight-bold">
                                <div class="d-inline-block"><span>{{ getContextualState() }}</span></div>

                                <span v-if="storeState.form.isSaving" class="pl-2">{{ trans.nav.notify.saving }}</span>
                                <span v-if="storeState.form.hasSuccess" class="pl-2 text-success">{{ trans.nav.notify.success }}</span>
                            </li>
                        </ul>

                        <a v-if="isPublished" href="#" class="btn btn-sm btn-outline-primary my-auto ml-auto" @click="save">
                            {{ trans.buttons.general.save }}
                        </a>

                        <a v-else href="#" class="btn btn-sm btn-outline-primary my-auto ml-auto" @click="showPublishModal">
                            {{ trans.buttons.posts.ready }}
                        </a>

                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link text-secondary pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sliders-h fa-fw fa-rotate-270"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <router-link :to="{name: 'stats-show', params: { id: id }}" v-if="isPublished" class="dropdown-item">
                                    {{ trans.nav.controls.stats }}
                                </router-link>
                                <div class="dropdown-divider" v-if="isPublished"></div>
                                <a href="#" class="dropdown-item" @click="showSettingsModal">
                                    {{ trans.nav.controls.settings }}
                                </a>
                                <a href="#" class="dropdown-item" @click="showFeaturedImageModal">
                                    {{ trans.nav.controls.image }}
                                </a>
                                <a href="#" class="dropdown-item" @click="showSeoModal">
                                    {{ trans.nav.controls.seo }}
                                </a>
                                <a  v-if="isPublished" href="#" class="dropdown-item" @click.prevent="convertToDraft">
                                    {{ trans.buttons.general.draft }}
                                </a>
                                <a v-if="id !== 'create'" href="#" class="dropdown-item text-danger" @click="showDeleteModal">
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
                                <textarea-autosize :placeholder="trans.posts.forms.editor.title"
                                                   class="form-control-lg form-control border-0 pl-0 serif"
                                                   rows="1"
                                                   v-model="storeState.form.title">
                                </textarea-autosize>
                            </div>
                        </div>

                        <quill-editor></quill-editor>
                    </div>
                </div>
            </div>
        </main>

        <publish-modal v-if="isReady"
                       ref="publishModal">
        </publish-modal>

        <settings-modal v-if="isReady"
                        ref="settingsModal"
                        :post="post"
                        :tags="tags"
                        :topics="topics">
        </settings-modal>

        <featured-image-modal v-if="isReady"
                              ref="featuredImageModal">
        </featured-image-modal>

        <seo-modal v-if="isReady"
                   ref="seoModal">
        </seo-modal>

        <delete-modal v-if="isReady"
                      ref="deleteModal"
                      @delete="deletePost"
                      :header="trans.posts.delete.header"
                      :message="trans.posts.delete.warning">
        </delete-modal>
    </div>
</template>

<script>
import Vue from "vue";
import $ from "jquery";
import moment from "moment";
import { store } from "./store";
import SeoModal from "../../components/SeoModal";
import DeleteModal from "../../components/DeleteModal";
import VueTextAreaAutosize from "vue-textarea-autosize";
import PublishModal from "../../components/PublishModal";
import SettingsModal from "../../components/SettingsModal";
import QuillEditor from "../../components/editor/QuillEditor";
import ProfileDropdown from "../../components/ProfileDropdown";
import FeaturedImageModal from "../../components/FeaturedImageModal";

Vue.use(VueTextAreaAutosize);

export default {
    name: "posts-edit",

    components: {
        PublishModal,
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

    computed: {
        isPublished() {
            return !!(
                this.post &&
                this.post.published_at <=
                    moment(new Date())
                        .tz(this.timezone)
                        .format()
                        .slice(0, 19)
                        .replace("T", " ")
            );
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
                    this.$router.push({ name: "posts" });
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
                            params: { id: response.data.id }
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

        convertToDraft() {
            this.storeState.form.published_at = "";
            this.save();
        },

        deletePost() {
            this.request()
                .delete("/api/posts/" + this.id)
                .then(response => {
                    $(this.$refs.deleteModal.$el).modal("hide");

                    this.$router.push({ name: "posts" });
                })
                .catch(error => {
                    // Add any error debugging...
                });
        },

        getContextualState() {
            return this.isPublished ? this.trans.nav.context.published : this.trans.nav.context.draft;
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
