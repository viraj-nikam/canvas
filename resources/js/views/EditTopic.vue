<template>
    <section>
        <page-header>
            <template slot="options">
                <div v-if="!creatingTopic" class="dropdown">
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
                        <a href="#" class="dropdown-item text-danger" @click="showDeleteModal"> {{ trans.delete }} </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div v-if="isReady" class="my-3">
                    <h2 class="mt-3">{{ creatingTopic ? trans.new_topic : trans.edit_topic }}</h2>
                    <p v-if="!creatingTopic" class="mt-2 text-secondary">
                        {{ trans.last_updated }} {{ moment(topic.updatedAt).fromNow() }}
                    </p>
                </div>

                <div v-if="isReady" class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-12 px-0">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.name }}
                                </label>
                                <input
                                    v-model="name"
                                    type="text"
                                    name="name"
                                    autofocus
                                    autocomplete="off"
                                    title="Name"
                                    class="form-control border-0"
                                    :placeholder="trans.give_your_topic_a_name"
                                    @keyup.enter="saveTopic"
                                />
                            </div>

                            <div class="col-12 mt-3 px-0">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.slug }}
                                </label>
                                <input
                                    v-model="slug"
                                    type="text"
                                    name="slug"
                                    disabled
                                    autocomplete="off"
                                    title="Slug"
                                    class="form-control border-0"
                                    :placeholder="trans.give_your_topic_a_name_slug"
                                />
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
                                    @click.prevent="saveTopic"
                                >
                                    {{ trans.save }}
                                </a>
                            </div>
                            <div class="col-md">
                                <router-link
                                    :to="{ name: 'topics' }"
                                    class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                >
                                    {{ trans.cancel }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="posts.length > 0" class="mt-5 card shadow-lg">
                    <div class="card-body p-0">
                        <div :key="`${index}-${post.id}`" v-for="(post, index) in posts">
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
                                                {{ trans.published }}
                                                {{ moment(post.published_at).format('MMM D, YYYY') }}
                                            </span>
                                            <span v-if="isDraft(post.published_at)">
                                                <span class="text-danger">{{ trans.draft }}</span>
                                                <span class="d-none d-md-inline">
                                                    ― {{ trans.updated }}
                                                    {{ moment(post.updated_at).fromNow() }}
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="d-none d-md-inline">
                                            <span class="text-secondary mr-3"
                                                >{{ suffixedNumber(post.views_count) }}
                                                {{ post.views_count == 1 ? trans.view : trans.views }}</span
                                            >
                                            <span class="mr-3"
                                                >{{ trans.created }}
                                                {{ moment(post.created_at).format('MMM D, YYYY') }}</span
                                            >
                                        </div>

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="25"
                                            viewBox="0 0 24 24"
                                            class="icon-cheveron-right-circle"
                                        >
                                            <circle cx="12" cy="12" r="10" style="fill: none" />
                                            <path
                                                class="fill-light-gray"
                                                d="M10.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <infinite-loading spinner="spiral" @infinite="fetchPosts">
                            <span slot="no-more" />
                            <div slot="no-results" />
                        </infinite-loading>
                    </div>
                </div>
            </div>
        </main>

        <delete-modal
            ref="deleteModal"
            :header="trans.delete"
            :message="trans.deleted_topics_are_gone_forever"
            @delete="deleteTopic"
        />
    </section>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import $ from 'jquery';
import DeleteModal from '../components/modals/DeleteModal';
import Hover from '../directives/Hover';
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import isEmpty from 'lodash/isEmpty';
import status from '../mixins/status';
import strings from '../mixins/strings';

export default {
    name: 'edit-topic',

    components: {
        DeleteModal,
        InfiniteLoading,
        PageHeader,
    },

    directives: {
        Hover,
    },

    mixins: [status, strings],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            name: '',
            slug: '',
            page: 1,
            posts: [],
            isReady: false,
        };
    },

    computed: {
        ...mapState(['topic']),
        ...mapGetters({
            trans: 'settings/trans',
        }),

        creatingTopic() {
            return this.$route.name === 'create-topic';
        },

        shouldDisableButton() {
            return isEmpty(this.slug);
        },
    },

    watch: {
        name(val) {
            this.slug = !isEmpty(val) ? this.slugify(val) : '';
        },

        async $route(to) {
            if (this.uri === 'create' && to.params.id === this.topic.id) {
                this.uri = to.params.id;
            }

            if (this.uri !== to.params.id) {
                this.isReady = false;
                this.uri = to.params.id;
                this.page = 1;
                this.posts = [];
                await Promise.all([this.fetchTopic(), this.fetchPosts()]);
                this.name = this.topic.name;
                this.slug = this.topic.slug;
                this.isReady = true;
                NProgress.done();
            }
        },
    },

    async created() {
        await Promise.all([this.fetchTopic(), this.fetchPosts()]);
        this.name = this.topic.name;
        this.slug = this.topic.slug;
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchTopic() {
            // TODO: This is a hack to ensure we have empty form fields
            this.$store.dispatch('topic/resetState');

            this.$store.dispatch('topic/fetchTopic', this.uri);
            NProgress.inc();
        },

        fetchPosts($state) {
            return this.request()
                .get(`/api/topics/${this.uri}/posts`, {
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

        saveTopic() {
            this.$store.dispatch('topic/updateTopic', {
                id: this.topic.id,
                name: this.name,
                slug: this.slug,
            });

            if (isEmpty(this.topic.errors) && this.creatingTopic) {
                this.$router.push({ name: 'edit-topic', params: { id: this.topic.id } });
                NProgress.done();
            }
        },

        deleteTopic() {
            this.$store.dispatch('topic/deleteTopic', this.topic.id);
            $(this.$refs.deleteModal.$el).modal('hide');
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
        },
    },
};
</script>
