<template>
    <div>
        <page-header>
            <template slot="menu" v-if="isReady">
                <div class="dropdown" v-if="!creatingTag">
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
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="#" class="dropdown-item text-danger" @click="showDeleteModal">
                            {{ i18n.delete }}
                        </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady && tag" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="my-3">
                    <h2 class="mt-3">{{ tag.name || i18n.new_tag }}</h2>
                    <p v-if="!creatingTag" class="mt-2 text-secondary">
                        {{ i18n.last_updated }} {{ moment(tag.updated_at).fromNow() }}
                    </p>
                </div>

                <div class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-12 px-0">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ i18n.name }}
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    autofocus
                                    autocomplete="off"
                                    :value="name"
                                    title="Name"
                                    @keyup.enter="saveTag"
                                    class="form-control border-0"
                                    :placeholder="i18n.give_your_tag_a_name"
                                />

                                <div v-if="tag.errors.name" class="invalid-feedback d-block">
                                    <strong>{{ tag.errors.name[0] }}</strong>
                                </div>
                            </div>

                            <div class="col-12 mt-3 px-0">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ i18n.slug }}
                                </label>
                                <input
                                    type="text"
                                    name="slug"
                                    disabled
                                    autocomplete="off"
                                    :value="slug"
                                    title="Slug"
                                    class="form-control border-0"
                                    :placeholder="i18n.give_your_tag_a_name_slug"
                                />
                                <div v-if="tag.errors.slug" class="invalid-feedback d-block">
                                    <strong>{{ tag.errors.slug[0] }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="col-md">
                                <a
                                    href="#"
                                    onclick="this.blur()"
                                    class="btn btn-success btn-block font-weight-bold mt-0"
                                    :class="shouldDisableButton ? 'disabled' : ''"
                                    aria-label="Save"
                                    @click.prevent="saveTag"
                                >
                                    {{ i18n.save }}
                                </a>
                            </div>
                            <div class="col-md">
                                <router-link
                                    :to="{ name: 'tags' }"
                                    class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                >
                                    {{ i18n.cancel }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 card shadow-lg" v-if="posts.length > 0">
                    <div class="card-body p-0">
                        <div v-for="(post, index) in posts" :key="`${index}-${post.id}`">
                            <router-link
                                :to="{
                                    name: 'edit-post',
                                    params: { id: post.id },
                                }"
                                class="text-decoration-none"
                            >
                                <div
                                    v-hover="{ class: `hover-bg` }"
                                    class="d-flex p-3 align-items-center"
                                    :class="{
                                        'border-top': index !== 0,
                                        'rounded-top': index === 0,
                                        'rounded-bottom': index === posts.length - 1,
                                    }"
                                >
                                    <div class="pl-2 col-md-6 col-sm-8 col-10">
                                        <p class="mb-0 mt-2 lead font-weight-bold text-truncate">
                                            {{ post.title }}
                                        </p>
                                        <p class="text-secondary mb-2">
                                            <span v-if="isPublished(post.published_at)">
                                                <span class="d-none d-md-inline"> {{ post.read_time }} ― </span>
                                                {{ i18n.published }}
                                                {{ moment(post.published_at).format('MMM D, YYYY') }}
                                            </span>
                                            <span v-if="isDraft(post.published_at)">
                                                <span class="text-danger">{{ i18n.draft }}</span>
                                                <span class="d-none d-md-inline">
                                                    ― {{ i18n.updated }}
                                                    {{ moment(post.updated_at).fromNow() }}
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="d-none d-md-inline">
                                            <span class="text-secondary mr-3"
                                                >{{ suffixedNumber(post.views_count) }} {{ i18n.views }}</span
                                            >
                                            <span class="mr-3"
                                                >{{ i18n.created }}
                                                {{ moment(post.created_at).format('MMM D, YYYY') }}</span
                                            >
                                        </div>

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="25"
                                            viewBox="0 0 24 24"
                                            class="icon-cheveron-right-circle"
                                        >
                                            <circle cx="12" cy="12" r="10" style="fill: none;" />
                                            <path
                                                class="fill-light-gray"
                                                d="M10.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <infinite-loading @infinite="fetchPosts" spinner="spiral">
                            <span slot="no-more"></span>
                            <div slot="no-results"></div>
                        </infinite-loading>
                    </div>
                </div>
            </div>
        </main>

        <delete-modal
            ref="deleteModal"
            @delete="deleteTag"
            :header="i18n.delete"
            :message="i18n.deleted_tags_are_gone_forever"
        >
        </delete-modal>
    </div>
</template>

<script>
import $ from 'jquery';
import NProgress from 'nprogress';
import PageHeader from './PageHeader';
import Hover from '../directives/Hover';
import DeleteModal from './modals/DeleteModal';
import i18n from '../mixins/i18n';
import toast from '../mixins/toast';
import InfiniteLoading from 'vue-infinite-loading';
import status from '../mixins/status';
import strings from '../mixins/strings';
import isEmpty from 'lodash/isEmpty';

export default {
    name: 'edit-tag',

    components: {
        DeleteModal,
        InfiniteLoading,
        PageHeader,
    },

    directives: {
        Hover,
    },

    mixins: [i18n, status, strings, toast],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            tag: null,
            name: null,
            slug: null,
            page: 1,
            posts: [],
            isReady: false,
        };
    },

    async created() {
        await Promise.all([this.fetchTag(), this.fetchPosts()]);
        this.isReady = true;
        NProgress.done();
    },

    watch: {
        name(val) {
            console.log(val);
            this.slug = !isEmpty(val) ? this.slugify(val) : '';
        },

        $route(to) {
            // this.isReady = false;
            // this.id = to.params.id;
            // this.name = null;
            // this.slug = null;
            // this.page = 1;
            // this.posts = [];
            // this.fetchTag();
            // this.fetchPosts();
            // this.isReady = true;
            // NProgress.done();
        },
    },

    computed: {
        tag() {
            return this.$store.state.tag;
        },

        name() {
            return this.tag.name || '';
        },

        slug() {
            return this.tag.slug || '';
        },

        creatingTag() {
            return this.$route.name === 'create-tag';
        },

        shouldDisableButton() {
            return isEmpty(this.tag.slug);
        },
    },

    methods: {
        fetchTag() {
            this.$store.dispatch('tag/fetchTag', this.uri);
            NProgress.inc();
        },

        fetchPosts($state) {
            return this.request()
                .get(`/api/tags/${this.uri}/posts`, {
                    params: {
                        page: this.page,
                    },
                })
                .then(({ data }) => {
                    if (!isEmpty(data) && !isEmpty(data.data)) {
                        this.page += 1;
                        this.posts.push(...data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }

                    if (isEmpty($state)) {
                        NProgress.inc();
                    }
                })
                .catch(() => {
                    NProgress.done();
                });
        },

        saveTag() {
            this.$store.dispatch('tag/updateTag', {
                id: this.uri,
                name: this.name,
                slug: this.slug,
            });

            if (this.creatingTag) {
                this.$router.push({ name: 'edit-tag', params: { id: data.id } });
            }

            toast.methods.toast(this.i18n.saved);
        },

        deleteTag() {
            this.$store.dispatch('tag/deleteTag', this.uri);
            $(this.$refs.deleteModal.$el).modal('hide');
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
        },
    },
};
</script>
