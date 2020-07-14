<template>
    <div>
        <page-header>
            <template slot="menu" v-if="isReady">
                <div class="dropdown" v-if="tag.id !== 'create'">
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
                            class="icon-dots-horizontal hover-light"
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

        <main v-if="isReady" class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-12 row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    Name
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    autofocus
                                    autocomplete="off"
                                    v-model="tag.name"
                                    title="Name"
                                    @keyup.enter="saveTag"
                                    class="form-control border-0"
                                    :placeholder="i18n.give_your_tag_a_name"
                                />

                                <div v-if="errors.name" class="invalid-feedback d-block">
                                    <strong>{{ errors.name[0] }}</strong>
                                </div>
                            </div>

                            <div class="col-12 mt-3 row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ i18n.slug }}
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    disabled
                                    autocomplete="off"
                                    v-model="tag.slug"
                                    title="Slug"
                                    class="form-control border-0"
                                    :placeholder="i18n.give_your_tag_a_name_slug"
                                />
                                <div v-if="errors.slug" class="invalid-feedback d-block">
                                    <strong>{{ errors.slug[0] }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-2">
                            <div class="col-md">
                                <a
                                    href="#"
                                    onclick="this.blur()"
                                    class="btn btn-success btn-block font-weight-bold mt-0"
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
    import PageHeader from '../components/PageHeader';
    import DeleteModal from '../components/modals/DeleteModal';
    import i18n from "../mixins/i18n";
    import toast from '../mixins/toast';
    import strings from "../mixins/strings";

    export default {
        name: 'edit-tag',

        components: {
            PageHeader,
            DeleteModal,
        },

        mixins: [ i18n, strings, toast ],

        data() {
            return {
                id: this.$route.params.id || 'create',
                tag: null,
                errors: [],
                isReady: false,
            };
        },

        async created() {
            await this.fetchTag();
            this.isReady = true;
            NProgress.done();
        },

        watch: {
            'tag.name'(val) {
                this.tag.slug = this.slugify(val);
            },
        },

        methods: {
            fetchTag() {
                return this.request()
                    .get('/api/tags/' + this.id)
                    .then(({ data }) => {
                        this.tag = data;
                        NProgress.inc();
                    })
                    .catch(() => {
                        this.$router.push({ name: 'tags' });
                        NProgress.done();
                    });
            },

            saveTag() {
                this.errors = [];

                this.request()
                    .post('/api/tags/' + this.id, {
                        name: this.tag.name,
                        slug: this.tag.slug
                    })
                    .then(({ data }) => {
                        this.id = data.id;
                        this.tag = data;
                        toast.methods.toast(this.i18n.saved);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors;
                    });
            },

            deleteTag() {
                this.request()
                    .delete('/api/tags/' + this.id)
                    .then(() => {
                        $(this.$refs.deleteModal.$el).modal('hide');
                        toast.methods.toast('Success');
                        this.$router.push({ name: 'tags' });
                    })
                    .catch(() => {
                        // Add any error debugging...
                    });
            },

            showDeleteModal() {
                $(this.$refs.deleteModal.$el).modal('show');
            },
        },
    };
</script>
