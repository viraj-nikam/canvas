<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ header }}
                    </p>
                    {{ message }}
                </div>
                <div class="modal-footer">
                    <a
                        href="#"
                        class="btn btn-danger"
                        aria-label="Delete"
                        @click.prevent="confirmProceed()"
                    >
                        {{ trans.buttons.general.delete }}
                    </a>
                    <button
                        type="button"
                        class="btn btn-link text-muted"
                        data-dismiss="modal"
                    >
                        {{ trans.buttons.general.cancel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteModal",

    props: {
        header: {
            type: String,
            required: true
        },
        message: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            trans: JSON.parse(this.Canvas.lang)
        };
    },

    methods: {
        confirmProceed() {
            this.$emit("delete");
        }
    }
};
</script>
