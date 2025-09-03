<template>
    <section>
        <page-header>
            <template slot="options">
                <div class="dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link pr-1"
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
                        <router-link :to="{ name: 'create-note' }" class="dropdown-item"> New note </router-link>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="d-flex justify-content-between mt-2 mb-4 align-items-center">
                    <h3 class="mt-2">Notes</h3>
                    <router-link :to="{ name: 'create-note' }" class="btn btn-outline-secondary">New note</router-link>
                </div>

                <div class="mt-5 card shadow-lg">
                    <div class="card-body p-0">
                        <div :key="`${index}-${note.id}`" v-for="(note, index) in notes">
                            <router-link
                                :to="{ name: 'edit-note', params: { id: note.id } }"
                                class="text-decoration-none"
                            >
                                <div
                                    v-hover="{ class: `hover-bg` }"
                                    class="d-flex p-3 align-items-center"
                                    :class="{
                                        'border-top': index !== 0,
                                        'rounded-top': index === 0,
                                        'rounded-bottom': index === notes.length - 1,
                                    }"
                                >
                                    <div class="pl-2 col-md-10 col-sm-10 col-10 py-1">
                                        <p class="my-1">
                                            {{ snippet(note.body) }}
                                        </p>
                                        <p class="text-secondary mt-1 mb-0">
                                            <span>
                                                {{ trans.created }}
                                                {{ moment(note.created_at).fromNow() }}
                                            </span>

                                            <span class="d-none d-md-inline">
                                                — {{ trans.updated }}
                                                {{ moment(note.updated_at).fromNow() }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="ml-auto pr-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
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

                        <infinite-loading :identifier="infiniteId" spinner="spiral" @infinite="fetchNotes">
                            <span slot="no-more" />
                            <div slot="no-results" class="text-left">
                                <div class="my-5">
                                    <p class="lead text-center text-muted mt-5">You have no notes</p>
                                    <p class="lead text-center text-muted mt-1">
                                        {{ trans.write_on_the_go }}
                                    </p>
                                </div>
                            </div>
                        </infinite-loading>
                    </div>
                </div>
            </div>
        </main>
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import Hover from '../directives/Hover';
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import isEmpty from 'lodash/isEmpty';

export default {
    name: 'note-list',

    components: {
        InfiniteLoading,
        PageHeader,
    },

    directives: {
        Hover,
    },

    data() {
        return {
            page: 1,
            notes: [],
            infiniteId: +new Date(),
            isReady: false,
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
            isContributor: 'settings/isContributor',
        }),
    },

    created() {
        this.fetchNotes();
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        snippet(text) {
            if (!text) return '(empty)';
            const clean = text.replace(/<[^>]+>/g, '').trim();
            return clean.length > 140 ? clean.substring(0, 140) + '…' : clean;
        },

        fetchNotes($state) {
            if ($state) {
                return this.request()
                    .get('/api/notes', {
                        params: {
                            page: this.page,
                            scope: this.isContributor ? 'user' : 'all',
                        },
                    })
                    .then(({ data }) => {
                        if (!isEmpty(data) && !isEmpty(data.notes.data)) {
                            this.page += 1;
                            this.notes.push(...data.notes.data);
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
            }
        },
    },
};
</script>
