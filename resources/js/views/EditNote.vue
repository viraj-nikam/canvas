<template>
    <section>
        <page-header>
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
                        <a href="#" class="dropdown-item" @click.prevent="showSettingsModal">
                            {{ trans.general_settings }}
                        </a>
                        <a href="#" class="dropdown-item" @click.prevent="saveNote">
                            {{ trans.save }}
                        </a>
                        <a v-if="!creatingNote" href="#" class="dropdown-item text-danger" @click="showDeleteModal">
                            {{ trans.delete }}
                        </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="form-group my-2">
                    <quill-editor
                        :key="note.id"
                        :post="note"
                        placeholder-text="What's on your mind?"
                        @update-post="saveNote"
                    />
                </div>
            </div>
        </main>

        <section v-if="isReady">
            <note-settings-modal
                ref="noteSettingsModal"
                :note="note"
                :tags="tags"
                :topics="topics"
                @add-tag="addTag"
                @add-topic="addTopic"
                @add-note-tag="addNoteTag"
                @add-note-topic="addNoteTopic"
                @update-note="saveNote"
            />
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
import $ from 'jquery';
import DeleteModal from '../components/modals/DeleteModal';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import QuillEditor from '../components/editor/QuillEditor';
import NoteSettingsModal from '../components/modals/NoteSettingsModal';
import debounce from 'lodash/debounce';
import get from 'lodash/get';
import isEmpty from 'lodash/isEmpty';

export default {
    name: 'edit-note',

    components: {
        DeleteModal,
        QuillEditor,
        PageHeader,
        NoteSettingsModal,
    },

    data() {
        return {
            uri: this.$route.params.id || 'create',
            note: {
                id: null,
                body: null,
                tags: [],
                topic: [],
            },
            tags: [],
            topics: [],
            isSaving: false,
            isSaved: false,
            errors: [],
            isReady: false,
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
        }),

        creatingNote() {
            return this.$route.name === 'create-note';
        },
    },

    watch: {
        async $route(to) {
            if (this.uri === 'create' && to.params.id === this.id) {
                this.uri = to.params.id;
            }

            if (this.uri !== to.params.id) {
                this.isReady = false;
                this.uri = to.params.id;
                await Promise.all([this.fetchNote()]);
                this.isReady = true;
                NProgress.done();
            }
        },
    },

    async created() {
        await Promise.all([this.fetchNote()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchNote() {
            return this.request()
                .get(`/api/notes/${this.uri}`)
                .then(({ data }) => {
                    this.note.id = data.note.id;
                    this.note.body = get(data.note, 'body', '');
                    this.note.tags = get(data.note, 'tags', []);
                    this.note.topic = get(data.note, 'topic', []);
                    this.tags = get(data, 'tags', []);
                    this.topics = get(data, 'topics', []);
                    NProgress.inc();
                })
                .catch(() => {
                    this.$router.push({ name: 'notes' });
                });
        },

        addTag(tag) {
            this.tags.push(tag);
        },

        addTopic(topic) {
            this.topics.push([topic]);
        },

        addNoteTag(tag) {
            this.note.tags.push(tag);
            this.saveNote();
        },

        addNoteTopic(topic) {
            this.note.topic = [topic];
            this.saveNote();
        },

        async saveNote() {
            this.errors = [];
            this.isSaving = true;
            this.isSaved = false;

            await this.request()
                .post(`/api/notes/${this.note.id}`, this.note)
                .then(({ data }) => {
                    this.isSaving = false;
                    this.isSaved = true;
                    this.note = data;
                    this.$store.dispatch('search/buildIndex', true);
                })
                .catch((error) => {
                    this.errors = get(error, 'response.data.errors', []);
                });

            if (isEmpty(this.errors) && this.creatingNote) {
                await this.$router.push({ name: 'edit-note', params: { id: this.note.id } });
                NProgress.done();
            }

            setTimeout(() => {
                this.isSaved = false;
                this.isSaving = false;
            }, 1500);
        },

        async deleteNote() {
            await this.request()
                .delete(`/api/notes/${this.note.id}`)
                .then(() => {
                    this.$store.dispatch('search/buildIndex', true);
                    this.$toasted.show(this.trans.success, { className: 'bg-success' });
                });

            $(this.$refs.deleteModal.$el).modal('hide');
            await this.$router.push({ name: 'notes' });
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
        },

        showSettingsModal() {
            $(this.$refs.noteSettingsModal.$el).modal('show');
        },
    },
};
</script>
