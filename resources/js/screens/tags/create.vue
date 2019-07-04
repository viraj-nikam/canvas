<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1">
                        <router-link to="/" class="navbar-brand font-weight-bold py-0">
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <a href="#" class="btn btn-sm btn-outline-primary my-auto ml-auto mr-3"
                           @click.prevent="submit" aria-label="Save">{{ trans.buttons.general.save }}</a>

                        <profile-dropdown></profile-dropdown>
                    </nav>
                </div>
            </div>
        </div>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form role="form"
                              id="create-tag"
                              method="POST">

                            <div class="form-group row my-5">
                                <div class="col-lg-12">
                                    <input required
                                           type="text"
                                           name="name"
                                           v-model="name"
                                           title="Name"
                                           class="form-control-lg form-control border-0 px-0"
                                           :placeholder="trans.tags.forms.placeholder">

                                    <div class="invalid-feedback d-block" v-if="errors.length">
                                        <strong v-for="error in errors">{{ error }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <p class="lead text-muted" style="cursor: default">
                                        <span class="text-primary">{{ slug }}</span>
                                    </p>
                                    <input type="hidden" name="slug" v-model="slug" readonly>
                                </div>
                            </div>
                        </form>
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
        name: 'tags-create',

        components: {
            uuid,
            ProfileDropdown
        },

        data() {
            return {
                endpoint: '/api/tags',
                name: '',
                errors: [],
                token: document.head.querySelector('meta[name="csrf-token"]').content,
                trans: JSON.parse(Canvas.lang),
            }
        },

        computed: {
            /**
             * Generate a version 4 (random) UUID.
             *
             * @returns {string}
             */
            id() {
                let uuidv4 = require('uuid/v4');

                return uuidv4();
            },

            /**
             * Generate a URL friendly "slug" from a given string.
             *
             * @returns {*|string}
             */
            slug() {
                return this.slugify(this.name);
            }
        },

        methods: {
            submit() {
                // todo: implement the form submission
            }
        }
    }
</script>

<style scoped>

</style>
