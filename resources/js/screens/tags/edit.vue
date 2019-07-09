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
                                <span v-if="form.isSaving">Saving...</span>
                                <span v-if="form.hasSuccess" class="text-success">Saved!</span>
                            </li>
                        </ul>

                        <a href="#"
                           class="btn btn-sm btn-outline-primary my-auto ml-auto"
                           @click="save"
                           aria-label="Save">
                            {{ trans.buttons.general.save }}
                        </a>

                        <div class="dropdown" v-if="id !== 'create'">
                            <a id="navbarDropdown" class="nav-link text-secondary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sliders-h fa-fw fa-rotate-270"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete">
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
                    <div class="col-md-8">
                        <div class="form-group row my-5">
                            <div class="col-lg-12">
                                <input required
                                       type="text"
                                       name="name"
                                       v-model="form.name"
                                       title="Name"
                                       class="form-control-lg form-control border-0 px-0"
                                       :placeholder="trans.tags.forms.placeholder">

                                <div class="invalid-feedback d-block">
                                    <strong v-for="error in form.errors">{{ error }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <p class="lead text-muted">
                                    <span class="text-primary">{{ form.slug }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import API from './api';
    import {uuid} from 'uuid';
    import ProfileDropdown from '../../components/ProfileDropdown';

    export default {
        name: 'tags-edit',

        components: {
            uuid,
            ProfileDropdown
        },

        data() {
            return {
                tag: null,
                id: this.$route.params.id || 'create',
                form: {
                    id: '',
                    name: '',
                    slug: '',
                    errors: [],
                    isSaving: false,
                    hasSuccess: false,
                    _token: document.head.querySelector('meta[name="csrf-token"]').content,
                },
                isReady: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.fetchData();
        },

        watch: {
            'form.name'(val) {
                this.form.slug = this.slugify(val);
            },
        },

        methods: {
            fetchData() {
                try {
                    this.tagsApiRequest({
                        id: this.id
                    }).then((e) => {
                        this.handleResponse(e);

                        this.isReady = true;
                    });
                } catch (error) {
                    console.error(error);
                }
            },

            tagsApiRequest(searchParams) {
                const promise = new Promise((resolve) => {
                    API.fetch(searchParams).then((response) => {
                        resolve(response.data);
                    }).catch((err) => {
                        resolve(err.response.data);
                        console.error(err);
                    });
                });

                return promise;
            },

            handleResponse(response) {
                this.$nextTick(() => {
                    this.tag = response.tag;
                    this.form.id = response.tag.id;

                    if (this.id !== 'create') {
                        this.form.name = response.tag.name;
                        this.form.slug = response.tag.slug;
                    }

                    this.isReady = true;
                });
            },

            save() {
                this.form.isSaving = true;
                this.form.errors = [];

                this.httpRequest().post('/api/tags/' + this.id, this.form).then(response => {
                    this.form.isSaving = false;
                    this.form.hasSuccess = true;
                }).catch(error => {
                    this.form.errors = error.response.data.errors;
                    this.form.isSaving = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
