<template>
    <div>
        <page-header>
            <template slot="status">
                <ul class="navbar-nav mr-auto flex-row float-right">
                    <li class="text-muted font-weight-bold">
                        <span v-if="form.isSaving">{{ trans.nav.notify.saving }}</span>
                        <span v-if="form.hasSuccess" class="text-success">{{ trans.nav.notify.success}}</span>
                    </li>
                </ul>
            </template>
        </page-header>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <h1 class="mt-2">Settings</h1>
                        </div>

                        <div class="mt-2" v-if="isReady">
                            <div class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto py-1">
                                    <p class="mb-1 font-weight-bold text-lg lead">
                                        Your profile
                                    </p>
                                    <p class="mb-1 d-none d-lg-block">
                                        Choose a username, summary and more to share.
                                    </p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="align-middle">
                                        <button class="btn btn-sm btn-outline-success font-weight-bold" @click="showProfileModal">Edit profile</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto py-1">
                                    <p class="mb-1 font-weight-bold text-lg lead">
                                        Weekly digest
                                    </p>
                                    <p class="mb-1 d-none d-lg-block">
                                        Control whether to receive a weekly summary of your published content.
                                    </p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="align-middle">
                                        <div class="form-group my-auto">
                                            <span class="switch switch-sm">
                                                <input
                                                    type="checkbox"
                                                    class="switch"
                                                    id="digest"
                                                    @change="toggleDigest"
                                                    :checked="form.digest"
                                                    v-model="form.digest"
                                                />
                                                <label for="digest" class="mb-0 sr-only">Weekly digest</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto py-1">
                                    <p class="mb-1 font-weight-bold text-lg lead">
                                        Dark mode
                                    </p>
                                    <p class="mb-1 d-none d-lg-block">
                                        Enable a dark appearance for Canvas.
                                    </p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="align-middle">
                                        <div class="form-group my-auto">
                                            <span class="switch switch-sm">
                                                <input
                                                    type="checkbox"
                                                    class="switch"
                                                    id="darkMode"
                                                    @change="toggleDarkMode"
                                                    :checked="form.darkMode"
                                                    v-model="form.darkMode"
                                                />
                                                <label for="darkMode" class="mb-0 sr-only">Dark mode</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto py-1">
                                    <p class="mb-1 font-weight-bold text-lg lead">
                                        Download your information
                                    </p>
                                    <p class="mb-1 d-none d-lg-block">
                                        Download a copy of the information you’ve shared on Canvas to a .zip file.
                                    </p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="align-middle">
                                        <button class="btn btn-sm btn-outline-success font-weight-bold">Download .zip</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <profile-modal
            v-if="isReady"
            ref="profileModal"
            :form="form"
        />
    </div>
</template>

<script>
    import $ from 'jquery';
    import PageHeader from '../../components/PageHeader'
    import ProfileModal from '../../components/ProfileModal';

    export default {
        name: 'settings-show',

        components: {
            PageHeader,
            ProfileModal
        },

        data() {
            return {
                form: {
                    username: null,
                    summary: null,
                    avatar: null,
                    digest: false,
                    darkMode: 0,
                    errors: [],
                    isSaving: false,
                    hasSuccess: false,
                },
                user: Canvas.user,
                isReady: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.fetchData()
        },

        methods: {
            fetchData() {
                this.request()
                    .get('/api/settings')
                    .then(response => {
                        this.form.username = response.data.username
                        this.form.summary = response.data.summary
                        this.form.avatar = response.data.avatar
                        this.form.digest = response.data.digest
                        this.form.darkMode = response.data.dark_mode

                        this.isReady = true
                    })
                    .catch(error => {
                        // Add any error debugging...
                    })
            },

            saveData(data, withNotification) {
                this.form.errors = []

                if (withNotification) {
                    this.form.isSaving = true
                    this.form.hasSuccess = false
                }

                this.request()
                    .post('/api/settings', data)
                    .then(response => {
                        if (withNotification) {
                            this.form.isSaving = false
                            this.form.hasSuccess = true
                        }

                        this.form.username = response.data.username
                        this.form.summary = response.data.summary
                        this.form.avatar = response.data.avatar
                        this.form.digest = response.data.digest
                        this.form.darkMode = response.data.dark_mode
                    })
                    .catch(error => {
                        this.form.isSaving = false
                        this.form.errors = error.response.data.errors
                    })
            },

            toggleDigest() {
                this.saveData({
                    digest: this.form.digest
                })
            },

            toggleDarkMode() {
                if (this.form.darkMode) {
                    $('#appearance').attr('href', '/vendor/canvas/css/app-dark.css')
                } else {
                    $('#appearance').attr('href', '/vendor/canvas/css/app.css')
                }

                this.saveData({
                    dark_mode: this.form.darkMode
                }, false)
            },

            showProfileModal() {
                $(this.$refs.profileModal.$el).modal('show')
            },
        },
    }
</script>
