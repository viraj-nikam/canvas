<template>
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        Profile
                    </p>

                    <div class="d-flex justify-content-center">
                        <img :src="avatar" class="w-50 rounded-circle shadow-inner"/>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">
                                Username
                            </label>
                            <input
                                name="username"
                                type="text"
                                class="form-control border-0 px-0 bg-transparent"
                                title="Username"
                                v-model="username"
                                placeholder="Username"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">
                                Summary
                            </label>
                            <textarea
                                rows="1"
                                id="summary"
                                name="summary"
                                class="form-control border-0 px-0 bg-transparent"
                                v-model="summary"
                                placeholder="Tell us a little bit about yourself...">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-lg order-lg-last px-0">
                            <a
                                href="#"
                                class="btn btn-success btn-block font-weight-bold mt-0"
                                aria-label="Delete"
                                @click.prevent="saveProfile()">
                                Save
                            </a>
                        </div>
                        <div class="col-lg order-lg-first px-0">
                            <button class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none" data-dismiss="modal">
                                {{ trans.buttons.general.cancel }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery'
    import autosize from 'autosize'
    import Tooltip from '../directives/Tooltip'

    export default {
        name: 'profile-modal',

        props: {
            form: {
                type: Object,
                required: true,
            },
        },

        directives: {
            Tooltip,
        },

        data() {
            return {
                trans: JSON.parse(Canvas.lang),
                username: this.form.username,
                summary: this.form.summary,
                avatar: this.form.avatar,
            }
        },

        mounted() {
            $('#profileModal').on('shown.bs.modal', function () {
                autosize($('#summary'))
            })
        },

        methods: {
            saveProfile() {
                this.form.errors = []
                this.form.isSaving = true
                this.form.hasSuccess = false

                this.request()
                    .post('/api/settings', this.form)
                    .then(response => {
                        this.form.isSaving = false
                        this.form.hasSuccess = true
                        this.username = response.data.username
                        this.summary = response.data.summary
                        this.avatar = response.data.avatar
                    })
                    .catch(error => {
                        this.form.isSaving = false
                        this.form.errors = error.response.data.errors
                    })
            },
        },
    }
</script>
