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
                                <span v-if="form.isSaving">{{ trans.nav.notify.saving }}</span>
                                <span v-if="form.hasSuccess" class="text-success">{{ trans.nav.notify.success }}</span>
                            </li>
                        </ul>

                        <a href="#"
                           :class="{ disabled : form.name === '' }"
                           class="btn btn-sm btn-outline-primary my-auto ml-auto"
                           @click="save"
                           aria-label="Save">
                            {{ trans.buttons.general.save }}
                        </a>

                        <div class="dropdown" v-if="id !== 'create'">
                            <a id="navbarDropdown"
                               class="nav-link text-secondary pr-0"
                               href="#"
                               role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
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

        <main class="py-4" v-if="isReady">
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
                this.request()
                    .get('/api/tags/' + this.id)
                    .then((response) => {
                        this.tag = response.data.tag;
                        this.form.id = response.data.tag.id;

                        if (this.id !== 'create') {
                            this.form.name = response.data.tag.name;
                            this.form.slug = response.data.tag.slug;
                        }

                        this.isReady = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            save() {
                this.form.hasSuccess = false;
                this.form.isSaving = true;
                this.form.errors = [];

                this.request()
                    .post('/api/tags/' + this.id, this.form)
                    .then((response) => {
                        this.form.isSaving = false;
                        this.form.hasSuccess = true;
                        this.id = response.data.tag.id;
                        this.tag = response.data.tag;
                    })
                    .catch((error) => {
                        this.form.isSaving = false;
                        this.form.errors = error.response.data.errors;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
