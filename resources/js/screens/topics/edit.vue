<template>
    <div>
        <div class="border-bottom">
            <div class="container d-flex justify-content-center px-0">
                <div class="col-md-10 px-0">
                    <nav
                        class="navbar navbar-light justify-content-between flex-nowrap flex-row py-1"
                    >
                        <router-link
                            to="/"
                            class="navbar-brand font-weight-bold py-0"
                        >
                            <i class="fas fa-align-left"></i>
                        </router-link>

                        <ul class="navbar-nav mr-auto flex-row float-right">
                            <li class="text-muted font-weight-bold">
                                <span v-if="form.isSaving">{{
                                    trans.nav.notify.saving
                                }}</span>
                                <span
                                    v-if="form.hasSuccess"
                                    class="text-success"
                                    >{{ trans.nav.notify.success }}</span
                                >
                            </li>
                        </ul>

                        <a
                            href="#"
                            :class="{ disabled: form.name === '' }"
                            class="btn btn-sm btn-outline-primary my-auto ml-auto"
                            @click="saveTopic"
                            :aria-label="trans.buttons.general.save"
                        >
                            {{ trans.buttons.general.save }}
                        </a>

                        <div class="dropdown" v-if="id !== 'create'">
                            <a
                                id="navbarDropdown"
                                class="nav-link text-secondary pr-0"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <i
                                    class="fas fa-sliders-h fa-fw fa-rotate-270"
                                ></i>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="dropdownMenuButton"
                            >
                                <a
                                    href="#"
                                    class="dropdown-item text-danger"
                                    @click="showDeleteModal"
                                >
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
                                <input
                                    type="text"
                                    name="name"
                                    autocomplete="off"
                                    v-model="form.name"
                                    title="Name"
                                    @keyup.enter="saveTopic"
                                    class="form-control-lg form-control border-0 px-0"
                                    :placeholder="
                                        trans.topics.forms.placeholder
                                    "
                                />

                                <div
                                    v-if="form.errors.name"
                                    class="invalid-feedback d-block"
                                >
                                    <strong>{{ form.errors.name[0] }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <p class="lead text-muted">
                                    <span class="text-primary">{{
                                        form.slug
                                    }}</span>
                                </p>
                                <div
                                    v-if="form.errors.slug"
                                    class="invalid-feedback d-block"
                                >
                                    <strong>{{ form.errors.slug[0] }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <delete-modal
            ref="deleteModal"
            @delete="deleteTopic"
            :header="trans.topics.delete.header"
            :message="trans.topics.delete.warning"
        >
        </delete-modal>
    </div>
</template>

<script>
import $ from "jquery";
import DeleteModal from "../../components/DeleteModal";
import ProfileDropdown from "../../components/ProfileDropdown";

export default {
    name: "topics-edit",

    components: {
        DeleteModal,
        ProfileDropdown
    },

    data() {
        return {
            topic: null,
            id: this.$route.params.id || "create",
            form: {
                id: "",
                name: "",
                slug: "",
                errors: [],
                isSaving: false,
                hasSuccess: false
            },
            isReady: false,
            trans: JSON.parse(this.Canvas.lang)
        };
    },

    mounted() {
        this.fetchData();
    },

    watch: {
        "form.name"(val) {
            this.form.slug = this.slugify(val);
        }
    },

    methods: {
        fetchData() {
            this.request()
                .get("/api/topics/" + this.id)
                .then(response => {
                    this.topic = response.data;
                    this.form.id = response.data.id;

                    if (this.id !== "create") {
                        this.form.name = response.data.name;
                        this.form.slug = response.data.slug;
                    }

                    this.isReady = true;
                })
                .catch(error => {
                    this.$router.push({ name: "topics" });
                });
        },

        saveTopic() {
            this.form.errors = [];
            this.form.isSaving = true;
            this.form.hasSuccess = false;

            this.request()
                .post("/api/topics/" + this.id, this.form)
                .then(response => {
                    this.form.isSaving = false;
                    this.form.hasSuccess = true;
                    this.id = response.data.id;
                    this.topic = response.data;
                })
                .catch(error => {
                    this.form.isSaving = false;
                    this.form.errors = error.response.data.errors;
                });
        },

        deleteTopic() {
            this.request()
                .delete("/api/topics/" + this.id)
                .then(response => {
                    $(this.$refs.deleteModal.$el).modal("hide");

                    this.$router.push({ name: "topics" });
                })
                .catch(error => {
                    // Add any error debugging...
                });
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal("show");
        }
    }
};
</script>
