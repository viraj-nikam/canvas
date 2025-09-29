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
                    <div class="d-flex align-items-center">
                        <select
                            v-model="selectedTag"
                            class="ml-auto w-auto custom-select border-0 mr-2"
                            @change="changeTag"
                        >
                            <option value="all">Untagged</option>
                            <option v-for="tag in tags" :key="tag.slug" :value="tag.slug">
                                {{ capitalize(tag.name) }}
                            </option>
                        </select>
                        <router-link :to="{ name: 'create-note' }" class="btn btn-outline-secondary"
                            >New note</router-link
                        >
                    </div>
                </div>

                <div class="mt-5 card shadow-lg">
                    <div class="card-body p-0">
                        <div :key="`${index}-${note.id}`" v-for="(note, index) in notes" class="position-relative">
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
                                        <p class="text-truncate lead font-weight-bold mb-0">
                                            {{ note.title || snippet(note.body) }}
                                        </p>
                                        <p v-if="note.title" class="text-truncate text-secondary my-1">
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
                                    <div class="ml-auto d-flex align-items-center">
                                        <!-- Item actions dropdown (left of arrow) -->
                                        <div class="dropdown mr-2" @click.prevent>
                                            <a
                                                class="nav-link p-0"
                                                id="navbarDropdown"
                                                role="button"
                                                tabindex="0"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                href="#"
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
                                                <a href="#" class="dropdown-item" @click.prevent="duplicateNote(note)"
                                                    >Duplicate</a
                                                >
                                                <a
                                                    href="#"
                                                    class="dropdown-item text-danger"
                                                    @click.prevent="showDeleteModal(note, index)"
                                                >
                                                    {{ trans.delete || 'Delete' }}
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Navigate arrow -->
                                        <div class="pr-2">
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
        <section v-if="isReady">
            <delete-modal
                ref="deleteModal"
                :header="trans.delete"
                message="Are you sure you want to delete this note?"
                @delete="deleteNote"
            />
        </section>
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import Hover from '../directives/Hover';
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import isEmpty from 'lodash/isEmpty';
import DeleteModal from '../components/modals/DeleteModal';
import $ from 'jquery';

export default {
    name: 'note-list',

    components: {
        InfiniteLoading,
        PageHeader,
        DeleteModal,
    },

    directives: {
        Hover,
    },

    data() {
        return {
            page: 1,
            notes: [],
            tags: [],
            selectedTag: 'all',
            infiniteId: +new Date(),
            isReady: false,
            pendingDeleteNote: null,
            pendingDeleteIndex: null,
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
            isContributor: 'settings/isContributor',
        }),
        userId() {
            return this.$store.state.settings.user && this.$store.state.settings.user.id;
        },
    },

    created() {
        // Load the last selected tag (persisted per user) before initial fetch
        try {
            const key = this.storageKey();
            const saved = key ? localStorage.getItem(key) : null;
            if (saved) {
                this.selectedTag = saved;
            }
        } catch (e) {
            // Ignore storage errors and fall back to default
        }

        this.fetchNotes();
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        async duplicateNote(note) {
            try {
                const { data } = await this.request().post(`/api/notes/${note.id}/duplicate`);
                this.$toasted && this.$toasted.show('Note duplicated', { className: 'bg-success' });
                // Navigate to the duplicated note for immediate editing
                this.$router.push({ name: 'edit-note', params: { id: data.id } });
            } catch (e) {
                this.$toasted && this.$toasted.show('Failed to duplicate', { className: 'bg-danger' });
            }
        },

        showDeleteModal(note, index) {
            this.pendingDeleteNote = note;
            this.pendingDeleteIndex = index;
            $(this.$refs.deleteModal.$el).modal('show');
        },
        async deleteNote() {
            const note = this.pendingDeleteNote;
            const index = this.pendingDeleteIndex;
            if (!note || index === null || index === undefined) return;
            try {
                await this.request().delete(`/api/notes/${note.id}`);
                this.notes.splice(index, 1);
                this.$toasted && this.$toasted.show(this.trans.success || 'Deleted', { className: 'bg-success' });
            } catch (e) {
                this.$toasted && this.$toasted.show('Failed to delete', { className: 'bg-danger' });
            } finally {
                $(this.$refs.deleteModal.$el).modal('hide');
                this.pendingDeleteNote = null;
                this.pendingDeleteIndex = null;
            }
        },
        capitalize(text) {
            if (!text || typeof text !== 'string') return '';
            return text.charAt(0).toUpperCase() + text.slice(1);
        },
        snippet(html) {
            if (!html) return '(empty)';
            // Parse HTML and preserve semantic hints for lists/checkboxes in plain text
            const container = document.createElement('div');
            container.innerHTML = html;

            const parts = [];
            const maxItemsPerList = 3; // keep snippets compact

            const processNode = (node) => {
                if (node.nodeType === Node.TEXT_NODE) {
                    const t = node.textContent.replace(/\s+/g, ' ').trim();
                    if (t) parts.push(t);
                    return;
                }
                if (node.nodeType !== Node.ELEMENT_NODE) return;

                const tag = node.tagName.toUpperCase();
                if (tag === 'UL' || tag === 'OL') {
                    const isOrdered = tag === 'OL';
                    const isChecklist = node.hasAttribute('data-checked');
                    const checked = node.getAttribute('data-checked') === 'true';
                    const items = Array.from(node.children).filter(
                        (c) => c.tagName && c.tagName.toUpperCase() === 'LI'
                    );
                    items.slice(0, maxItemsPerList).forEach((li, i) => {
                        const text = li.textContent.replace(/\s+/g, ' ').trim();
                        if (!text) return;
                        let prefix = ' ';
                        if (isChecklist) {
                            prefix = checked ? '[x] ' : '[ ] ';
                        } else if (isOrdered) {
                            prefix = `${i + 1}. `;
                        }
                        parts.push(prefix + text);
                    });
                    return;
                }

                if (['P', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'BLOCKQUOTE', 'PRE'].includes(tag)) {
                    const t = node.textContent.replace(/\s+/g, ' ').trim();
                    if (t) parts.push(t);
                    return;
                }

                Array.from(node.childNodes).forEach(processNode);
            };

            Array.from(container.childNodes).forEach(processNode);

            let summary = parts.join('  ').replace(/\s+/g, ' ').trim();
            if (summary.length > 140) summary = summary.substring(0, 140) + '…';
            return summary || '(empty)';
        },

        fetchNotes($state) {
            if ($state) {
                return this.request()
                    .get('/api/notes', {
                        params: {
                            page: this.page,
                            scope: this.isContributor ? 'user' : 'all',
                            tag: this.selectedTag,
                        },
                    })
                    .then(({ data }) => {
                        if (Array.isArray(data.tags)) {
                            this.tags = data.tags;
                        }
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

        changeTag() {
            this.page = 1;
            this.notes = [];
            this.infiniteId += 1;
            // Persist selection for subsequent sessions (per user)
            try {
                const key = this.storageKey();
                if (key) {
                    localStorage.setItem(key, this.selectedTag);
                }
            } catch (e) {
                // Ignore storage errors
            }
        },

        storageKey() {
            return this.userId ? `canvas:notes:selectedTag:${this.userId}` : null;
        },
    },
};
</script>
