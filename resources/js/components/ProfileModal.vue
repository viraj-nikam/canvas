<template>
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <input
                        hidden
                        type="file"
                        ref="file"
                        accept="image/*"
                        @change="onAvatarChange"
                    />

                    <p class="font-weight-bold lead">
                        Edit Profile
                    </p>

                    <div class="d-flex justify-content-center bg-black">
                        <img
                            :src="data.avatar"
                            class="w-50 rounded-circle shadow-inner my-3"
                            style="cursor:pointer"
                            @click.prevent="launchFilePicker"
                        />
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                Username
                            </label>
                            <input
                                name="username"
                                type="text"
                                class="form-control border-0 px-0 bg-transparent"
                                title="Username"
                                v-model="data.username"
                                placeholder="Choose a username..."
                            />
                            <div v-if="form.errors.username" class="invalid-feedback d-block">
                                <strong>{{ form.errors.username[0] }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold text-uppercase text-muted small">
                                Summary
                            </label>
                            <textarea
                                rows="1"
                                id="summary"
                                name="summary"
                                class="form-control border-0 px-0 bg-transparent"
                                v-model="data.summary"
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
                                aria-label="Save"
                                @click.prevent="update(true)">
                                {{ trans.buttons.general.save }}
                            </a>
                        </div>
                        <div class="col-lg order-lg-first px-0">
                            <button
                                class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                data-dismiss="modal">
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

    export default {
        name: 'profile-modal',

        props: {
            form: {
                type: Object,
                required: false,
            },
        },

        data() {
            return {
                data: {
                    username: this.form.username,
                    summary: this.form.summary,
                    avatar: this.form.avatar,
                },
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            $('#profileModal').on('shown.bs.modal', function () {
                autosize($('#summary'))
            })
        },

        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },

            onAvatarChange(event) {
                let file = event.target.files[0]
                let formData = new FormData()

                formData.append('image', file, file.name)

                this.request()
                    .post('/api/media/uploads', formData)
                    .then(response => {
                        this.data.avatar = response.data
                        this.update(false)
                        this.$root.$emit('updateAvatar', response.data)
                    })
                    .catch(error => {
                        // Add any error debugging...
                    })
            },

            update(hidesModal) {
                this.$parent.saveData(this.data, true, hidesModal)
            },
        },
    }
</script>

<style scoped>
    img:hover {
        opacity: 0.6;
    }
</style>
